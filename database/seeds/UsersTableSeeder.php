<?php

use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::insert([
            'name' => 'Admin Admin',
            'email' => 'admin@material.com',
            'email_verified_at' => now(),
            'password' => bcrypt('secret'),
            'line' => '',
            'facebook' => '',
            'avatar' => '',
            'level' => 100,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        for ($i=1; $i < 9; $i++) { 
            \App\User::insert([
                'name' => 'เซียน '.$i,
                'email' => 'z'.$i.'@z'.$i.'.com',
                'email_verified_at' => now(),
                'password' => bcrypt('z'.$i.'@z'.$i.'.com'),
                'line' => '',
                'facebook' => '',
                'avatar' => '',                
                'level' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);         
        }      
    }
}
