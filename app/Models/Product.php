<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'harga', 'description', 'category', 'image', 'image_width', 'image_height', 'image_fit', 'stock', 'is_available', 'rating', 'spice_level', 'is_best_seller'])]
class Product extends Model {}
