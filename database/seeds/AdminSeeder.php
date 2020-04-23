<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::query()->create([
            'email' => 'ismail@oreganoapps.com',
            'name' => 'Ismail',
            'password' => bcrypt('@Ismail123@'),
        ]);
    }
}
