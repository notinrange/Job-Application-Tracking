<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Default User model

class HRAuthController extends Controller
{
    /**
     * Show the HR admin login form.
     */
    public function showLoginForm()
    {
        return view('hr.login');
    }

    /**
     * Process the HR admin login request.
     */
    public function login(Request $request)
    {
        // Validate the form data.
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to log the user in.
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Regenerate session to prevent fixation.
            $request->session()->regenerate();

            // Redirect to the HR dashboard.
            return redirect()->intended(route('hr.dashboard'));
        }

        // If login fails, redirect back with an error message.
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    /**
     * Show the HR admin registration form.
     */
    public function showRegisterForm()
    {
        return view('hr.register');
    }

    /**
     * Process the HR admin registration request.
     */
    public function register(Request $request)
    {
        // Validate the incoming data.
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create the user (HR admin) record.
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Log the new HR admin in.
        Auth::login($user);

        // Redirect to the HR dashboard with a success message.
        return redirect()->route('hr.dashboard')->with('success', 'Registration successful.');
    }

    /**
     * Log the HR admin out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page.
        return redirect()->route('hr.login');
    }
}
