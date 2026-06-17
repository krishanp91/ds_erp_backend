<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'fxml_path', 'display_name', 'parent_id', 'depth', 'permission_type', 'active'
    ];

    public function parent(){
        return $this->belongsTo('App\Permission', 'parent_id');
    }

    public function children() { 
        return $this->hasMany('App\Permission', 'parent_id', 'id'); 
    }
}
