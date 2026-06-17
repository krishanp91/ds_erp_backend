<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationUser extends Model
{
  public function User(){
    return $this->belongsTo('App\Models\User', 'user_id');
  }

  public function Location(){
    return $this->belongsTo('App\Models\Location', 'location_id');
  }
}
