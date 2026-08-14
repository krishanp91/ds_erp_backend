<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ContactDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'contact_name', 'designation', 'email', 'phone', 'mobile',
        'is_primary', 'created_by', 'updated_by', 'deleted_by'
    ];

    protected $guarded = ['id', 'deleted_at'];

    public static function boot()
    {
        parent::boot();

        ContactDetail::deleting(function ($contactDetail) {
            $contactDetail->deleted_by = Auth::id();
            $contactDetail->save();
        });

        ContactDetail::restoring(function ($contactDetail) {
            $contactDetail->deleted_by = null;
            $contactDetail->save();
        });
    }
}
