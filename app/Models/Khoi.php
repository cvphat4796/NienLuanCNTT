<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Khoi extends Model
{
   	protected $table = 'khoi';
    protected $primaryKey = 'khoi_maso';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
      'khoi_maso', 'khoi_mota'];


    public function monhocs()
    {
        return $this->belongsToMany("App\Models\MonHoc","chitietkhoi","khoi_maso","mh_maso");
    }

    public function nganhhocs()
    {
        return $this->belongsToMany("App\Models\NganhHoc","khoinganh","khoi_maso","ngh_id");
    }
}
