<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userOwner = User::create([
            'name' => 'Gede Dito April Yanto Wijaya',
            'email' => 'dito@admin.com',
            'phone' => '085213148149',
            'roles' => 'ADMIN',
            'profile_photo' => 'images/default-avatar.png',
            'password' => bcrypt('12345678'),
        ]);
    }
}
