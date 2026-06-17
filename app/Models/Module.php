<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
  protected $fillable = [
    'module_code', 'module_name', 'default_screen', 'active'
  ];
}
