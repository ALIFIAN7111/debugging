<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'price', 'original_price', 'badge', 'description', 'image', 'image_width', 'image_height', 'image_fit', 'is_active', 'is_popular'])]
class Bundle extends Model {}
