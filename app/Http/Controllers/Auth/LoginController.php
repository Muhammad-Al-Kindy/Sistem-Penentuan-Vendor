<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller has custom
    | authentication logic implemented in the authenticate method.
    |
    */

    use AuthenticatesUsers;


    protected $redirectTo = '/kriteria';

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if user exists, if not create user
        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            $user = User::create([
                'name' => explode('@', $credentials['email'])[0], // Use email prefix as name
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
            ]);
            Log::info('New user created at login', ['user_id' => $user->id, 'email' => $user->email]);

            Auth::login($user);
            $request->session()->regenerate();

            Log::info('User logged in', ['user_id' => $user->id, 'email' => $user->email, 'ip' => $request->ip()]);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Authenticated',
                    'user' => $user,
                ]);
            }
            // Redirect based on role
            if ($user->isVendor()) {
                return redirect()->route('vendor.reports')->with('login_success', true);
            }
            return redirect()->route('kriteria.index')->with('login_success', true);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            Log::info('User logged in', ['user_id' => $user->id ?? null, 'email' => $user->email, 'ip' => $request->ip()]);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Authenticated',
                    'user' => $user,
                ]);
            }
            // Redirect based on role
            if ($user->isVendor()) {
                return redirect()->route('vendor.reports')->with('login_success', true);
            }
            return redirect()->route('kriteria.index')->with('login_success', true);
        }

        Log::warning('Failed login attempt', ['email' => $request->input('email'), 'ip' => $request->ip()]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'The provided credentials do not match our records.',
            ], 401);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('logout_success', true);
    }
}