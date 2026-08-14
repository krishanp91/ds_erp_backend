<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class SupplierContact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'supplier_id', 'contact_detail_id', 'active',
        'created_by', 'updated_by', 'deleted_by'
    ];

    protected $guarded = ['id', 'deleted_at'];

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id');
    }

    public function contactDetail()
    {
        return $this->belongsTo('App\Models\ContactDetail', 'contact_detail_id');
    }

    public static function boot()
    {
        parent::boot();

        SupplierContact::deleting(function ($supplierContact) {
            $supplierContact->active = 0;
            $supplierContact->deleted_by = Auth::id();
            $supplierContact->save();
        });

        SupplierContact::restoring(function ($supplierContact) {
            $supplierContact->active = 1;
            $supplierContact->deleted_by = null;
            $supplierContact->save();
        });
    }
}
