<?php
namespace App\Http\Controllers\Affiliate\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('affiliate.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('agent')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Example: Check if password reset is required (customize as needed)
            $agent = Auth::guard('agent')->user();
            if (isset($agent->must_change_password) && $agent->must_change_password) {
                return redirect()->route('affiliate.change-password');
            }

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Logged in']);
            }
            return redirect()->intended('/affiliate/dashboard');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'The provided credentials do not match our records.',
            ], 422);
        }
        // Redirect back with error message
        return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::guard('agent')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/affiliate/login');
    }
}
