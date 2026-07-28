<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ProductBarcode extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'item_id', 'barcode', 'barcode_type', 'active',
        'created_by', 'updated_by', 'deleted_by'
    ];

    protected $guarded = ['id', 'deleted_at'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'item_id');
    }

    public static function boot()
    {
        parent::boot();

        ProductBarcode::deleting(function ($productBarcode) {
            $productBarcode->active = 0;
            $productBarcode->deleted_by = Auth::id();
            $productBarcode->save();
        });

        ProductBarcode::restoring(function ($productBarcode) {
            $productBarcode->active = 1;
            $productBarcode->deleted_by = null;
            $productBarcode->save();
        });
    }
}
