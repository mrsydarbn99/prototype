<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = new User();
        return view('users.createUser', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:1,2',
            'role' => 'required|string|exists:roles,name',
        ], [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a valid string.',
            'name.max' => 'Name must not exceed 255 characters.',

            'username.required' => 'Username is required.',
            'username.string' => 'Username must be a valid string.',
            'username.max' => 'Username must not exceed 255 characters.',
            'username.unique' => 'This username is already taken.',

            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a valid string.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',

            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either 1 or 2.',

            'role.required' => 'Role is required.',
            'role.exists' => 'Selected role is invalid.',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'password' => bcrypt($validatedData['password']),
            'status' => $validatedData['status'],
        ]);

        $user->assignRole($validatedData['role']);

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
        $modelRole = $user->getRoleNames()->first();

        return view('users.editUser', compact('user', 'modelRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:1,2',
            'role' => 'required|string|exists:roles,name'
        ], [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a valid string.',
            'name.max' => 'Name must not exceed 255 characters.',
            
            'username.required' => 'Username is required.',
            'username.string' => 'Username must be a valid string.',
            'username.max' => 'Username must not exceed 255 characters.',
            'username.unique' => 'This username is already taken.',
            
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a valid string.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either 1 or 2.',

            'role.required' => 'Role is required.',
            'role.exists' => 'Selected role is invalid.',
        ]);
        // Find the user by ID and update their information
        $user = User::findOrFail($id);
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        if ($validatedData['password']) {
            $user->password = bcrypt($validatedData['password']);
        }
        $user->status = $validatedData['status'];
        $user->save();

        $user->syncRoles([$validatedData['role']]);

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
        $users = User::with('roles')->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'status' => $user->status,
                'roles' => $user->roles->pluck('name')->implode(', ')
            ];
        });

        return response()->json(['data' => $users]);
    }

    public function editOwn()
    {
        $user = User::findOrFail(Auth::id());
        return view('users.editProfile', ['user' => $user, 'modelRole' => $user->roles->pluck('name')->first()]);
    }

    public function updateOwn(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a valid string.',
            'name.max' => 'Name must not exceed 255 characters.',
            
            'username.required' => 'Username is required.',
            'username.string' => 'Username must be a valid string.',
            'username.max' => 'Username must not exceed 255 characters.',
            'username.unique' => 'This username is already taken.',
            
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a valid string.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }
        $user->save();


        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
