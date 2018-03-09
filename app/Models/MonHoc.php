<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonHoc extends Model
{
    protected $table = 'monhoc';
    protected $primaryKey = 'mh_maso';
    public $incrementing = false;

    protected $fillable = [
      'mh_maso', 'mh_ten'];

    public function khois()
    {
        return $this->belongsToMany("App\Models\Khoi","chitietkhoi","khoi_maso","mh_maso");//->withPivot('khoi_mota', 'khoi_maso','mh_ten');
    }
}
