<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'quantity', 'unit', 'production_date'])]
class ProductionStock extends Model {}
