<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, softDeletes;

    protected $table='categories';
    protected $guarded=[];

    public function children()
    {
        return $this->hasMany(Category::class , 'parent_id');
    }

    public function parent()
    {
        return $this->hasMany(Category::class , 'children_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class );
    }
}
