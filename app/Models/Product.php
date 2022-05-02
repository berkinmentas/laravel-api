<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $hidden = ['slug '];

//hangi kolonlarda ekleme veya güncelleme yapacağımızı belli etmeye yarıyor
    protected $fillable = ['name', 'slug', 'price'];

//    seçinlen kolonlarda ekleme ve update gizleme
//    protected $fillable = ['name', 'slug', 'price'];

    public function categories(){
        return $this->belongsToMany('App\Models\Category', 'product_categories');
    }


}
//protected $guarded = [];
