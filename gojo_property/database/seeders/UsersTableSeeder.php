<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            //admin
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin111@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'admin',
                'status' => 'active',
            ],
            [
                'name' => 'Hermela',
                'username' => 'hermi',
                'email' => 'hermiadmin@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'admin',
                'status' => 'active',
            ],
            //agent
            [
                'name' => 'agent',
                'username' => 'agent',
                'email' => 'agent111@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'agent',
                'status' => 'active',

            ],
            //customer
            [
                'name' => 'Customer',
                'username' => 'customer',
                'email' => 'customer111@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'customer',
                'status' => 'active',

            ],
        ]);
    }
}
