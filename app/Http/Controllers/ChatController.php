<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        if ($user->role === 'admin') {
            $vendors = Vendor::with('user')->get();
            return view('admin.chat.chat', compact('vendors'));
        } elseif ($user->role === 'vendor') {
            return $this->vendorChat();
        } else {
            abort(403, 'Unauthorized');
        }
    }

    public function vendorChat()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'vendor') {
            abort(403, 'Unauthorized');
        }
        $admin = User::where('role', 'admin')->first();
        $reportId = request()->route('reportId', null);
        return view('vendor.chat', ['admin' => $admin, 'reportId' => $reportId]);
    }

    /**
     * Store a newly created chat message and broadcast the event.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || (! method_exists($user, 'isAdmin') || ! method_exists($user, 'isVendor') || (! $user->isAdmin() && ! $user->isVendor()))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        try {
            $validated = $request->validate([
                'to_id' => 'required|exists:users,idUser',
                'message' => 'required|string|max:1000',
            ]);

            // Force to_id to admin if sender is vendor
            if ($user->isVendor()) {
                $admin = User::where('role', 'admin')->first();
                if ($admin) {
                    $validated['to_id'] = $admin->idUser;
                }
            }

            $authId = $user->idUser;

            Log::info('Storing chat message', [
                'from_id' => $authId,
                'to_id' => $validated['to_id'],
                'message' => $validated['message'],
            ]);

            $chatMessage = ChatMessage::create([
                'from_id' => $authId,
                'to_id' => $validated['to_id'],
                'message' => $validated['message'],
            ]);

            broadcast(new ChatMessageSent($chatMessage))->toOthers();

            return response()->json([
                'status' => 'success',
                'message' => 'Message sent successfully',
                'data' => $chatMessage,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('ChatController@store error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send message',
            ], 500);
        }
    }

    /**
     * Fetch chat messages between authenticated user and the selected user.
     */
    public function fetchMessages(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,idUser',
            ]);

            $authUserId = Auth::id();
            $otherUserId = $validated['user_id'];

            Log::info("fetchMessages called", ['authUserId' => $authUserId, 'otherUserId' => $otherUserId]);

            $messages = ChatMessage::where(function ($query) use ($authUserId, $otherUserId) {
                $query->where('from_id', $authUserId)->where('to_id', $otherUserId);
            })->orWhere(function ($query) use ($authUserId, $otherUserId) {
                $query->where('from_id', $otherUserId)->where('to_id', $authUserId);
            })->orderBy('created_at', 'asc')->get();

            Log::info("fetchMessages result count: " . $messages->count());

            return response()->json([
                'status' => 'success',
                'messages' => $messages,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('ChatController@fetchMessages error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch messages',
            ], 500);
        }
    }
}
