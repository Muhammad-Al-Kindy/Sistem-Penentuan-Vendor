<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->idUser . ',idUser',
            'role' => 'required|string|in:Admin,Vendor',
        ]);

        $user->update($validated);

        if ($request->ajax()) {
            return response()->json(['message' => 'Data berhasil diperbarui!']);
        }

        return redirect()->route('users.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}