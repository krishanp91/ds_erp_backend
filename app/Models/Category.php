<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_name', 'description', 'parent_id', 'active'
    ];

    protected $guarded = ['id', 'deleted_at'];

    public function parent() {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function children() { 
        return $this->hasMany('App\Models\Category', 'parent_id', 'id'); 
    }

    public static function boot(){
        parent::boot();

        Category::deleting(function($category) {
            $category->active = 0;
            $category->save();
        });

        Category::restoring(function ($category) {
            $category->active = 1;
            $category->save();
        });
    }
}
