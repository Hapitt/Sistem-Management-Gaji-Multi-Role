<?php

namespace Database\Seeders;


use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Manager Perusahaan',
            'email' => 'manager@gmail.com',
            'role' => UserRole::Manager->value,
            'password' => Hash::make('123456789'),
        ]);
    }
}
