<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.register');
    }

    /**
     * Handle registration form submission.
     */
    public function register(Request $request)
    {
        // Validate all registration fields
        $request->validate([
            'name'                    => 'required|string|max:255',
            'email'                   => 'required|email|unique:users,email',
            'password'                => 'required|min:8|confirmed',
            'phone'                   => 'required|string|max:20',
            'blood_group'             => 'required|string|max:5',
            'emergency_contact_name'  => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'relation'                => 'required|string|max:50',
        ]);

        // Create the user
        $user = User::create([
            'name'                    => $request->name,
            'email'                   => $request->email,
            'password'                => Hash::make($request->password),
            'phone'                   => $request->phone,
            'blood_group'             => $request->blood_group,
            'emergency_contact_name'  => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'relation'                => $request->relation,
            'role'                    => 'user', // Default role is user
        ]);

        // Auto-login after registration
        Auth::login($user);

        return redirect('/')
            ->with('success', 'Registration successful! Welcome, ' . $user->name . '!');
    }
}
