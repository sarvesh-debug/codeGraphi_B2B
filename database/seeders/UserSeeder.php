<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Sarvesh',
            'username' => 'sarvesh@codegraphi',
            'role' => 'admin',
            'email' => 'sarvesh@codegraphi.com',
            'phone' => '9621122159',
            'password' => Hash::make('code@graphi'), // encrypt the password
        ]);
    }
}
