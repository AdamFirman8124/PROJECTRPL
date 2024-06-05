<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CafeProduct extends Model
{
    use HasFactory;

    protected $table = 'cafe_products'; // Nama tabel di database

    protected $fillable = ['name', 'description', 'price', 'image']; // Kolom yang dapat diisi
}
