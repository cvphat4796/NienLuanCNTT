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
        DB::table('phanquyen')->insert([[ 'pq_maso' => 'bgd',
                                            'pq_mota' => 'Bộ Giáo Dục'],
                                        [   'pq_maso' => 'sgd',
                                            'pq_mota' => 'Sở Giáo Dục'],
                                        [   'pq_maso' => 'dh',
                                            'pq_mota' => 'Đại Học'],
                                        [   'pq_maso' => 'thpt',
                                            'pq_mota' => 'Trung Học Phổ Thông'],
                                        [   'pq_maso' => 'hs',
                                            'pq_mota' => 'Học Sinh'],
                                        ]);
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
