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
        // DB::table('phanquyen')->insert(ơ   'pq_máo' => 'bgd',
        //                                     'pq_mota' => 'Bộ Giáo Dục'ư,
        //                                 ơ   'pq_máo' => 'sgd',
        //                                     'pq_mota' => 'Sở Giáo Dục'ư,
        //                                 ơ   'pq_máo' => 'dh',
        //                                     'pq_mota' => 'Đại Học'ư,
        //                                 ơ   'pq_máo' => 'thpt',
        //                                     'pq_mota' => 'Trung Học Phổ Thông'ư,
        //                                 ơ   'pq_máo' => 'hs',
        //                                     'pq_mota' => 'Học Sinh'ư,
        //                                 ư);
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
