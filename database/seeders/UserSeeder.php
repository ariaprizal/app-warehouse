<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => "fazri",
                'email' => "fazri@mailinator.com",
                'role' => "warehouse",
                'password' => bcrypt(12345678), // password
                'remember_token' => random_int(10, 10),
            ],
            [
                'name' => "saeful",
                'email' => "saeful@mailinator.com",
                'role' => "purchasing",
                'password' => bcrypt(12345678), // password
                'remember_token' => random_int(10, 10),
            ],
            [
                'name' => "Ronald",
                'email' => "ronald@mailinator.com",
                'role' => "finance",
                'password' => bcrypt(12345678), // password
                'remember_token' => random_int(10, 10),
            ],
            [
                'name' => "Bayu",
                'email' => "bayu@mailinator.com",
                'role' => "marketing",
                'password' => bcrypt(12345678), // password
                'remember_token' => random_int(10, 10),
            ],
        ];

        foreach($users as $user){
            User::create($user);
        }
    }
}
