<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'     => 'Filippo Sallemi',
            'email'    => 'filippo@sallemi.it',
            'password' => Hash::make('12345678')
        ]);
    }
}
