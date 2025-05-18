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
        // Fetch all users from the database
        $users = User::all();

        // dd($users);
        // Return the users to a view
        return view('users.userList', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $d['model']=new User();
        return view('users.createUser', $d);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:1,2',
        ]);

        // Create a new user in the database
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'status' => $validatedData['status'],
        ]);

        // Redirect to the user list with a success message
        return redirect()->route('userlist')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $d['model'] = $user;

        return view('users.editUser', $d);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:1,2',
        ]);

        // Find the user by ID and update their information
        $user = User::findOrFail($id);
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        if ($validatedData['password']) {
            $user->password = bcrypt($validatedData['password']);
        }
        $user->status = $validatedData['status'];
        $user->save();

        // Redirect to the user list with a success message
        return redirect()->route('userlist')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the user by ID and delete them
        $user = User::findOrFail($id);
        $user->delete();

        // Redirect to the user list with a success message
        return redirect()->route('userlist')->with('success', 'User deleted successfully.');
    }

    public function getData()
    {
        $users = User::select('id', 'name', 'email', 'status')->get();

        return response()->json(['data' => $users]);
    }
}
