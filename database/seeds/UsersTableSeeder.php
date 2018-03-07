<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            'user_id' => 'bogd',
            'pq_maso' => 'bgd',
            'user_pass' => bcrypt('12345'),
        ]);
    }
}
