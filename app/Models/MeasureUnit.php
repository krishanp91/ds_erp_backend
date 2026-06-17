<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeasureUnit extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'unit_name', 'unit_code', 'description', 'active'
    ];

    protected $guarded = ['id', 'deleted_at'];

    public static function boot(){
        parent::boot();

        MeasureUnit::deleting(function($measureUnit) {
            $measureUnit->active = 0;
            $measureUnit->save();
        });

        MeasureUnit::restoring(function ($measureUnit) {
            $measureUnit->active = 1;
            $measureUnit->save();
        });
    }
}
