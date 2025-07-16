<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Models\ChatMessage;
use App\Models\NonConformance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    // File: app/Http/Controllers/ChatController.php
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $vendors = Vendor::with('user')->get();

            // Kalau pakai select(), tambahkan 'keterangan'
            $nonConformanceReports = \App\Models\NonConformance::with([
                'goodsReceiptItem.goodsReceipt.vendor.user'
            ])->get();


            return view('admin.chat.chat', compact('vendors', 'nonConformanceReports'));
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
        Log::info('vendorChat user vendor relationship:', ['vendor' => $user->vendor]);
        Log::info('vendorChat user vendor idVendor:', ['idVendor' => $user->vendor->idVendor ?? null]);
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            abort(404, 'Admin user not found. Please contact support.');
        }
        Log::info('vendorChat admin user:', ['admin' => $admin]);
        Log::info('vendorChat admin user id:', ['admin_id' => $admin->idUser ?? null]);
        $reportId = request()->route('reportId', request()->query('reportId', null));

        // If reportId is null, try to get the latest non_conformance for this vendor
        if (is_null($reportId)) {
            $nonConformance = \App\Models\NonConformance::whereHas('goodsReceiptItem.goodsReceipt', function ($query) use ($user) {
                $query->where('vendor_id', $user->vendor->idVendor ?? 0);
            })->latest('tanggal_ditemukan')->first();
        } else {
            $nonConformance = \App\Models\NonConformance::where('idNonConformance', $reportId)->first();
        }

        $nonConformanceId = $nonConformance ? $nonConformance->idNonConformance : null;

        return view('vendor.chat_new', [
            'admin' => $admin,
            'reportId' => $reportId,
            'nonConformanceId' => $nonConformanceId,
        ]);
    }

    /**
     * Store a newly created chat message and broadcast the event.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['admin', 'vendor'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        try {
            $validated = $request->validate([
                'to_id' => 'required|exists:users,idUser',
                'message' => 'required|string|max:1000',
                'non_conformance_id' => 'nullable|exists:non_conformances,idNonConformance',
            ]);

            // Force to_id to admin if sender is vendor
            if ($user->role === 'vendor') {
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
                'non_conformance_id' => $validated['non_conformance_id'] ?? null,
            ]);

            $chatMessage = ChatMessage::create([
                'from_id' => $authId,
                'to_id' => $validated['to_id'],
                'message' => $validated['message'],
                'non_conformance_id' => $validated['non_conformance_id'] ?? null,
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
                'from_id' => 'required|exists:users,idUser',
                'to_id' => 'required|exists:users,idUser',
                'non_conformance_id' => 'required|exists:non_conformances,idNonConformance',
            ]);

            $authUserId = $validated['from_id']; // atau bisa pakai Auth::id() jika konsisten
            $otherUserId = $validated['to_id'];
            $nonConformanceId = $validated['non_conformance_id'];

            Log::info("fetchMessages called", [
                'authUserId' => $authUserId,
                'otherUserId' => $otherUserId,
                'nonConformanceId' => $nonConformanceId,
            ]);

            $query = ChatMessage::where(function ($query) use ($authUserId, $otherUserId) {
                $query->where(function ($q) use ($authUserId, $otherUserId) {
                    $q->where('from_id', $authUserId)
                        ->where('to_id', $otherUserId);
                })->orWhere(function ($q) use ($authUserId, $otherUserId) {
                    $q->where('from_id', $otherUserId)
                        ->where('to_id', $authUserId);
                });
            })->where('non_conformance_id', $nonConformanceId);

            $messages = $query->orderBy('created_at', 'asc')->get();

            Log::info("Fetched {$messages->count()} messages");
            foreach ($messages as $msg) {
                Log::info("Message: from {$msg->from_id} to {$msg->to_id} - {$msg->message}");
            }

            return response()->json([
                'status' => 'success',
                'messages' => $messages->map(function ($msg) {
                    return [
                        'id' => $msg->id,
                        'from_id' => $msg->from_id,
                        'to_id' => $msg->to_id,
                        'message' => $msg->message,
                        'non_conformance_id' => $msg->non_conformance_id,
                        'created_at' => $msg->created_at->toDateTimeString(),
                    ];
                }),
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



    // Temporary debug method to fetch all chat messages for current vendor without filters
    public function debugFetchAllMessagesForVendor()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'vendor') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        // Get all chat messages where from_id or to_id is the vendor's user id
        $messages = ChatMessage::where(function ($query) use ($user) {
            $query->where('from_id', $user->idUser)
                ->orWhere('to_id', $user->idUser);
        })->orderBy('created_at', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'messages' => $messages,
        ]);
    }

    // Temporary debug method to fetch all chat messages for current admin without filters
    public function debugFetchAllMessagesForAdmin()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        // Get all chat messages where from_id or to_id is the admin's user id
        $messages = ChatMessage::where(function ($query) use ($user) {
            $query->where('from_id', $user->idUser)
                ->orWhere('to_id', $user->idUser);
        })->orderBy('created_at', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'messages' => $messages,
        ]);
    }
}