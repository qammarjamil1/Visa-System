<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user')->latest();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }

        $users = $query->withCount('visaApplications')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = ['name' => $request->name, 'email' => $request->email];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    // Admin apni credentials change kare
    public function credentials()
    {
        return view('admin.credentials');
    }

    public function updateCredentials(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'email'            => 'required|email',
            'password'         => 'required|min:6|confirmed',
        ]);

        $admin = auth()->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is wrong.']);
        }

        $admin->update([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Credentials updated successfully!');
    }
}