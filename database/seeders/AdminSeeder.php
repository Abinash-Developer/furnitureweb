<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Abinash swain',
            'email' => 'abinashswain45678@gmail.com',
            'contact_number'=>'7077430068',
            'password' => bcrypt('1234'),
            'role' => 'admin',
        ]);
    }
}
