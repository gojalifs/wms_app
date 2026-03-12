<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('name')->get();

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'role'  => ['required', 'in:admin,user'],
        ]);

        try {
            $tempPassword = Str::random(10);

            User::create([
                'name'                 => $validated['name'],
                'email'                => $validated['email'],
                'role'                 => $validated['role'],
                'password'             => Hash::make($tempPassword),
                'must_change_password' => true,
            ]);

            return redirect()->route('users.index')
                ->with('success', __('wms.users.created'))
                ->with('temp_password', $tempPassword)
                ->with('temp_user', $validated['name']);
        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', __('wms.users.error_create', ['message' => $e->getMessage()]));
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', __('wms.users.cannot_delete_self'));
        }

        try {
            $user->delete();

            return redirect()->route('users.index')
                ->with('success', __('wms.users.deleted'));
        } catch (\Throwable $e) {
            return back()->with('error', __('wms.users.error_delete', ['message' => $e->getMessage()]));
        }
    }
}
