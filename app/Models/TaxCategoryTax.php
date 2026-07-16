<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxCategoryTax extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tax_category_id', 'tax_id', 'sequence'
    ];

    protected $guarded = ['id', 'deleted_at'];

    public function taxCategory()
    {
        return $this->belongsTo('App\Models\TaxCategory', 'tax_category_id');
    }

    public function tax()
    {
        return $this->belongsTo('App\Models\Tax', 'tax_id');
    }
}
