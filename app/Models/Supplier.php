<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'id', 'first_name', 'last_name', 'company_name', 'contact_person', 'mobile_no', 
        'contact_detail_id', 'active'
    ];

    public function contactDetail() {
        return $this->belongsTo('App\ContactDetail', 'contact_detail_id');
    }
}
