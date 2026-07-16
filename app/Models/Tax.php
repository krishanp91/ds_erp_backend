<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'rate', 'type', 'calculation_method', 'is_active'
    ];

    protected $guarded = ['id', 'deleted_at'];

    public function taxCategoryTaxes()
    {
        return $this->hasMany('App\Models\TaxCategoryTax', 'tax_id');
    }

    public function taxCategories()
    {
        return $this->belongsToMany('App\Models\TaxCategory', 'tax_category_taxes', 'tax_id', 'tax_category_id')
            ->withPivot('sequence')
            ->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();

        Tax::deleting(function ($tax) {
            $tax->is_active = 0;
            $tax->save();
        });

        Tax::restoring(function ($tax) {
            $tax->is_active = 1;
            $tax->save();
        });
    }
}
