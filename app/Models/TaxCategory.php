<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'is_active'
    ];

    protected $guarded = ['id', 'deleted_at'];

    public function taxCategoryTaxes()
    {
        return $this->hasMany('App\Models\TaxCategoryTax', 'tax_category_id');
    }

    public function taxes()
    {
        return $this->belongsToMany('App\Models\Tax', 'tax_category_taxes', 'tax_category_id', 'tax_id')
            ->withPivot('sequence')
            ->withTimestamps()
            ->orderBy('tax_category_taxes.sequence');
    }

    public static function boot()
    {
        parent::boot();

        TaxCategory::deleting(function ($taxCategory) {
            $taxCategory->is_active = 0;
            $taxCategory->save();
        });

        TaxCategory::restoring(function ($taxCategory) {
            $taxCategory->is_active = 1;
            $taxCategory->save();
        });
    }
}
