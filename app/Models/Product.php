<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = ['name', 'slug', 'description', 'price'];

    public function formatPriceValue($price)
    {
        $price = str_replace(",", ".", $price);
        $price = number_format(floatval($price), 2);

        return $price;
    }
}
