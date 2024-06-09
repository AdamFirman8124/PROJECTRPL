<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Purchase extends Model
{
    protected $fillable = [
        'product_id',   // ID produk yang dibeli
        'user_id',      // ID pengguna yang melakukan pembelian
        'quantity',     // Jumlah produk yang dibeli
        'total_price',  // Total harga dari pembelian
        'notes'         // Catatan dari pengguna
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($purchase) {
            Log::info('Pembelian baru telah dibuat:', ['id' => $purchase->id]);
        });

        static::updated(function ($purchase) {
            Log::info('Pembelian telah diperbarui:', ['id' => $purchase->id]);
        });

        static::deleted(function ($purchase) {
            Log::info('Pembelian telah dihapus:', ['id' => $purchase->id]);
        });
    }

    /**
     * Mendapatkan produk yang terkait dengan pembelian.
     */
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    /**
     * Mendapatkan pengguna yang melakukan pembelian.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
