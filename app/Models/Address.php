<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Address extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'address_type', 'address_line_1', 'address_line_2', 'address_line_3',
        'city', 'district', 'province', 'postal_code', 'is_primary', 'active',
        'created_by', 'updated_by', 'deleted_by'
    ];

    protected $guarded = ['id', 'deleted_at'];

    public static function boot()
    {
        parent::boot();

        Address::deleting(function ($address) {
            $address->active = 0;
            $address->deleted_by = Auth::id();
            $address->save();
        });

        Address::restoring(function ($address) {
            $address->active = 1;
            $address->deleted_by = null;
            $address->save();
        });
    }
}
