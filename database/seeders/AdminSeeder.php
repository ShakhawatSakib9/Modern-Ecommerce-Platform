<?php

namespace Database\Seeders;

use App\Models\Backend\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@clothingstore.com',
            'password' => Hash::make('admin123'),
        ]);

        Admin::create([
            'name' => 'Manager',
            'email' => 'manager@clothingstore.com',
            'password' => Hash::make('manager123'),
        ]);
    }
}
