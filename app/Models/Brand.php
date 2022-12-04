<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $connection   = 'mysql';
    protected $table = 'brands';
    use HasFactory;
}
