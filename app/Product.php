<?php

namespace App;
use App\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable= ['name', 'spec', 'categories_id','price', 'picture'];

    public function category(){

       return   $this->belongsTo(Category::class);

    }
}
