<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class SupplierAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'supplier_id', 'address_id', 'active',
        'created_by', 'updated_by', 'deleted_by'
    ];

    protected $guarded = ['id', 'deleted_at'];

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Address', 'address_id');
    }

    public static function boot()
    {
        parent::boot();

        SupplierAddress::deleting(function ($supplierAddress) {
            $supplierAddress->active = 0;
            $supplierAddress->deleted_by = Auth::id();
            $supplierAddress->save();
        });

        SupplierAddress::restoring(function ($supplierAddress) {
            $supplierAddress->active = 1;
            $supplierAddress->deleted_by = null;
            $supplierAddress->save();
        });
    }
}
