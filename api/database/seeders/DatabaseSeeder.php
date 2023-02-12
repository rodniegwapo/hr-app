<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\role;
use App\Models\User;
use Psy\Util\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['name' => Role::ROLE_ADMIN]);
        Role::firstOrCreate(['name' => Role::ROLE_MANAGER]);
        Role::firstOrCreate(['name' => Role::ROLE_EMPLOYEE]);
        $user = User::create([
            'firstname' => 'test',
            'lastname' => 'test',
            'email' => 'test@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole(\App\Models\Role::ROLE_ADMIN);
        $user = User::create([
            'firstname' => 'manager1',
            'lastname' => 'manager1',
            'email' => 'manager1@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole(\App\Models\Role::ROLE_MANAGER);
        $user = User::create([
            'firstname' => 'Manager2',
            'lastname' => 'Manger2',
            'email' => 'mager2@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole(\App\Models\Role::ROLE_MANAGER);
        $user = User::create([
            'firstname' => 'staff',
            'lastname' => 'staff',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('password'),
            'manager_id' => 3
        ]);
        $user->assignRole(\App\Models\Role::ROLE_EMPLOYEE);
        $this->call([
            TimeOffType::class
        ]);
    }
}
