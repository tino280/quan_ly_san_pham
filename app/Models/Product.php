<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type_id', 'producer_id', 'price', 'description', 'image_link',];

    public function producer() {
        return $this->belongsTo(Producer::class);
    }

    public function type() {
        return $this->belongsTo(Type::class);
    }

    // protected function getPriceFormatAttribute()
    // {
    //     return  '$ ' . number_format(intval( $this->price ));
    // }
}
