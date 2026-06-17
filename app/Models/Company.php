<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
  protected $fillable = [
    'company_name', 'company_address1', 'company_address2', 'company_address3', 'company_tel1', 'company_tel2', 
    'company_fax', 'company_email', 'company_web'
  ];
}
