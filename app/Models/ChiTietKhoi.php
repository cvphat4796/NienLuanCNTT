<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietKhoi extends Pivot
{
    protected $table = 'chitietkhoi';
    protected $primaryKey = ['khoi_maso','mh_maso'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
      'khoi_maso', 'mh_maso'];
}
