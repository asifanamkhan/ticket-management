<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Admin;
        $admin->name = 'Admin';
        $admin->email = 'admin@autoville.com';
        $admin->password = Hash::make('password');
        $admin->is_super = 1;

        $admin->save();
    }
}
