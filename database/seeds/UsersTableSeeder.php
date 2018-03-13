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
        // DB::table('phanquyen')->insert([[ 'pq_máo' => 'bgd',
        //                                     'pq_mota' => 'Bộ Giáo Dục'],
        //                                 [   'pq_máo' => 'sgd',
        //                                     'pq_mota' => 'Sở Giáo Dục'],
        //                                 [   'pq_máo' => 'dh',
        //                                     'pq_mota' => 'Đại Học'],
        //                                 [   'pq_máo' => 'thpt',
        //                                     'pq_mota' => 'Trung Học Phổ Thông'],
        //                                 [   'pq_máo' => 'hs',
        //                                     'pq_mota' => 'Học Sinh'],
        //                                 ]);
         DB::table('users')->insert([
            'user_id' => 'bogd',
            'user_name' => 'Bộ Giáo Dục',
            'user_addr' => 'Hà Nội',
            'user_phone' => '01122334455',
            'pq_maso' => 'bgd',
            'user_pass' => bcrypt('12345'),
        ]);
    }
}
