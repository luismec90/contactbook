<?php

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'name' => 'Luis Montoya',
            'email' => 'luismec90@gmail.com',
            'password' => Hash::make('secret123'),
        ]);
    }

}