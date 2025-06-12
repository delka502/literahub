<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengembalians';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'peminjaman_id',
        'tanggal_pengembalian',
        'status', // null for normal returns, 'rusak' for damaged, 'hilang' for lost
        'denda',
        'keterangan',
        'status_pembayaran',
        'tanggal_pembayaran',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_pengembalian' => 'datetime',
        'tanggal_pembayaran' => 'datetime',
        'status_pembayaran' => 'boolean',
        'denda' => 'decimal:2',
    ];

    /**
     * Get the borrowing record that owns this return.
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }
}