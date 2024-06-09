<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'image'];
    protected $table = 'products'; // Nama tabel di database
    // Pastikan tabel dan kolom di database sudah benar
}

