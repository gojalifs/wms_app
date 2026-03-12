<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ChangePasswordController extends Controller
{
    public function show(): View
    {
        return view('auth.change-password');
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = $request->user();
        $user->update([
            'password'             => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect()->route('dashboard')
            ->with('success', __('wms.change_password.updated'));
    }
}
