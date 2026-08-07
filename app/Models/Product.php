<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'item_code', 'product_name', 'product_description', 'product_type',
        'category_id', 'low_stock_qty', 'unit_id', 'on_sale', 'active', 'company_id',
        'tax_category_id'
    ];

    protected $guarded = ['id', 'deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function measureUnit()
    {
        return $this->belongsTo('App\Models\MeasureUnit', 'unit_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id');
    }

    public function taxCategory()
    {
        return $this->belongsTo('App\Models\TaxCategory', 'tax_category_id');
    }

    public function barcodes()
    {
        return $this->hasMany('App\Models\ProductBarcode', 'item_id');
    }

    public static function boot()
    {
        parent::boot();

        Product::deleting(function ($product) {
            $product->active = 0;
            $product->save();
        });

        Product::restoring(function ($product) {
            $product->active = 1;
            $product->save();
        });
    }
}
