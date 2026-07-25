<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
        [
            'name' => 'Unit Pemilik Risiko',
            'username' => 'upr',
            'email' => 'upr@gmail.com',
            'password' => Hash::make('upr12345'),
            'role' => 'UPR',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Unit Manajemen Risiko',
            'username' => 'umr',
            'email' => 'umr@gmail.com',
            'password' => Hash::make('umr12345'),
            'role' => 'UMR',
            'created_at' => now(),
            'updated_at' => now(),  
        ],
        [
            'name' => 'Unit Pengawas Intern',
            'username' => 'upi',
            'email' => 'upi@gmail.com',
            'password' => Hash::make('upi12345'),
            'role' => 'UPI',
            'created_at' => now(),
            'updated_at' => now(),
        ]
        ]);
    }
}
