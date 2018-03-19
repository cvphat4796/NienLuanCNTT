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
        DB::table('khuvuc')->insert([['kv_maso' => 'KV1',
                                        'kv_ten' => 'Khu Vực 1',
                                        'kv_diemcong' => 0.75],
                                    ['kv_maso' => 'KV2',
                                        'kv_ten' => 'Khu Vực 2',
                                        'kv_diemcong' => 0.25],
                                    ['kv_maso' => 'KV2-NT',
                                        'kv_ten' => 'Khu Vực 2 Nông Thôn',
                                        'kv_diemcong' => 0.5],
                                    ['kv_maso' => 'KV3',
                                        'kv_ten' => 'Khu Vực 3',
                                        'kv_diemcong' => 0]
                                    ]);
        DB::table('loaithoigian')->insert([['ltg_maso' => 'LTG01',
                                        'ltg_ten' => 'Tạo Tài Khoản Học Sinh'],
                                    ['ltg_maso' => 'LTG02',
                                        'ltg_ten' => 'Nhập Điểm Cho Học Sinh'],
                                    ['ltg_maso' => 'LTG03',
                                        'ltg_ten' => 'Nộp Hồ Sơ Xét Tuyển Đại Học']
                                    ]);

        DB::table('users')->insert([
            'user_id' => 'bogd',
            'user_name' => 'Bộ Giáo Dục',
            'user_addr' => 'Hà Nội',
            'user_phone' => '01122334455',
            'pq_maso' => 'bgd',
            'user_pass' => bcrypt('12345'),
        ]);

        DB::table('monhoc')->insert([[ 'mh_maso' => 'TO',
                                            'mh_ten' => 'Toán'],
                                        [   'mh_maso' => 'VA',
                                            'mh_ten' => 'Ngữ Văn'],
                                        [   'mh_maso' => 'AN',
                                            'mh_ten' => 'Tiếng Anh'],
                                        [   'mh_maso' => 'LY',
                                            'mh_ten' => 'Vật Lý'],
                                        [   'mh_maso' => 'HO',
                                            'mh_ten' => 'Hóa Học'],
                                        [   'mh_maso' => 'SI',
                                            'mh_ten' => 'Sinh Học'],
                                        [   'mh_maso' => 'SU',
                                            'mh_ten' => 'Lịch Sử'],
                                        [   'mh_maso' => 'DI',
                                            'mh_ten' => 'Địa Lí'],
                                        [   'mh_maso' => 'CD',
                                            'mh_ten' => 'Giáo Dục Công Dân'],
                                        [   'mh_maso' => 'NG',
                                            'mh_ten' => 'Tiếng Nga'],
                                        [   'mh_maso' => 'PH',
                                            'mh_ten' => 'Tiếng Pháp'],
                                        [   'mh_maso' => 'TR',
                                            'mh_ten' => 'Tiếng Trung'],
                                        [   'mh_maso' => 'DU',
                                            'mh_ten' => 'Tiếng Đức'],
                                        [   'mh_maso' => 'NH',
                                            'mh_ten' => 'Tiếng Nhật']
                                        ]);
    }
}
