<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Insert Admin User
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Admin User',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $admin = User::find($adminId);
        $admin->assignRole('admin');

        // Insert Normal User
        $userId = DB::table('users')->insertGetId([
            'name' => 'Normal User',
            'username' => 'user',
            'password' => Hash::make('user'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::find($userId);
        $user->assignRole('user');
    }
}
