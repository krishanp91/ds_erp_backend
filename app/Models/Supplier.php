<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'supplier_code', 'supplier_name', 'credit_limit', 'credit_period',
        'tax_category_id', 'active', 'created_by', 'updated_by', 'deleted_by'
    ];

    protected $guarded = ['id', 'deleted_at'];

    protected $casts = [
        'credit_limit' => 'float',
        'credit_period' => 'integer',
    ];

    public function taxCategory()
    {
        return $this->belongsTo('App\Models\TaxCategory', 'tax_category_id');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\SupplierContact', 'supplier_id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\SupplierAddress', 'supplier_id');
    }

    public static function boot()
    {
        parent::boot();

        Supplier::deleting(function ($supplier) {
            $supplier->active = 0;
            $supplier->deleted_by = Auth::id();
            $supplier->save();
        });

        Supplier::restoring(function ($supplier) {
            $supplier->active = 1;
            $supplier->deleted_by = null;
            $supplier->save();
        });
    }
}
