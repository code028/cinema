<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.user.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            "name" => "string|required",
            "username" => "string|required",
            "email" => "email|required",
            "phone" => "string|required",
            "birthday" => "date|required",
            "role" => "string|in:user,moderator,admin"
        ]);

        if($user->role == "admin"){
            $user->update([
                "name" => $request->name,
                "username" => $request->username,
                "email" => $request->email,
                "phone" => $request->phone,
                "birthday" => $request->birthday,
            ]);
        }else {
            $user->update([
                "name" => $request->name,
                "username" => $request->username,
                "email" => $request->email,
                "phone" => $request->phone,
                "birthday" => $request->birthday,
                "role" => $request->role
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = User::findOrFail($id);

        $room->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
