<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Update the user's profile fields.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'phone'                       => ['required', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($user->id)],
            'blood_group'                 => 'required|string|max:5',
            // Contact 1 (mandatory)
            'emergency_contact_name'      => 'required|string|max:255',
            'emergency_contact_phone'     => 'required|string|max:20',
            'relation'                    => 'required|string|max:50',
            // Contact 2 (optional)
            'emergency_contact2_name'     => 'nullable|string|max:255',
            'emergency_contact2_phone'    => 'nullable|string|max:20',
            'emergency_contact2_relation' => 'nullable|string|max:50',
            // Contact 3 (optional)
            'emergency_contact3_name'     => 'nullable|string|max:255',
            'emergency_contact3_phone'    => 'nullable|string|max:20',
            'emergency_contact3_relation' => 'nullable|string|max:50',
            // Password
            'password'                    => 'nullable|min:8|confirmed',
        ]);

        // ── Duplicate phone check across all contacts ──
        $userPhone  = trim($request->phone);
        $contact1   = trim($request->emergency_contact_phone);
        $contact2   = trim($request->emergency_contact2_phone ?? '');
        $contact3   = trim($request->emergency_contact3_phone ?? '');

        $errors = [];

        // Contact 1 must not match user's own phone
        if ($contact1 === $userPhone) {
            $errors['emergency_contact_phone'] = 'Emergency contact phone cannot be the same as your own phone number.';
        }

        // Contact 2 duplicate checks (only if provided)
        if ($contact2 !== '') {
            if ($contact2 === $userPhone) {
                $errors['emergency_contact2_phone'] = 'Contact 2 phone cannot be the same as your own phone number.';
            } elseif ($contact2 === $contact1) {
                $errors['emergency_contact2_phone'] = 'Contact 2 phone cannot be the same as Contact 1.';
            }
        }

        // Contact 3 duplicate checks (only if provided)
        if ($contact3 !== '') {
            if ($contact3 === $userPhone) {
                $errors['emergency_contact3_phone'] = 'Contact 3 phone cannot be the same as your own phone number.';
            } elseif ($contact3 === $contact1) {
                $errors['emergency_contact3_phone'] = 'Contact 3 phone cannot be the same as Contact 1.';
            } elseif ($contact2 !== '' && $contact3 === $contact2) {
                $errors['emergency_contact3_phone'] = 'Contact 3 phone cannot be the same as Contact 2.';
            }
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }

        // ── Build update data ──
        $data = [
            'phone'                       => $userPhone,
            'blood_group'                 => $request->blood_group,
            // Contact 1
            'emergency_contact_name'      => $request->emergency_contact_name,
            'emergency_contact_phone'     => $contact1,
            'relation'                    => $request->relation,
            // Contact 2
            'emergency_contact2_name'     => $request->emergency_contact2_name ?: null,
            'emergency_contact2_phone'    => $contact2 ?: null,
            'emergency_contact2_relation' => $request->emergency_contact2_relation ?: null,
            // Contact 3
            'emergency_contact3_name'     => $request->emergency_contact3_name ?: null,
            'emergency_contact3_phone'    => $contact3 ?: null,
            'emergency_contact3_relation' => $request->emergency_contact3_relation ?: null,
        ];

        // Update password only if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }
}
