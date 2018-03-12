<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NganhHoc extends Model
{
    protected $table = 'nganhhoc';
    protected $primaryKey = 'ngh_id';
    public $incrementing = false;
    public $timestamps = false;

    

    public function khois()
    {
        return $this->belongsToMany("App\Models\Khoi","khoinganh","ngh_id","khoi_maso");
    }
}
