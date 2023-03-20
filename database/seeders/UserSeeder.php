<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $isCheckUsers = DB::table('users')->select(['*'])->count();

        if ($isCheckUsers == 0) {
            DB::table('users')->insert([
                'name' => 'admin_blog',
                'email' => 'admin',
                'password' => Hash::make('admin'),
            ]);
        }
    }
}
