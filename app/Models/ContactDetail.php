<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactDetail extends Model
{
    protected $fillable = [
        'id', 'address_line_1', 'address_line_2', 'address_line_3', 'address_line_4', 
        'mobile_no', 'telephone', 'email', 'active'
    ];
}
