<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RabItem extends Model
{
    protected $table = 'rab_items';

    protected $fillable = [
        'rab_id',
        'uraian',
        'volume',
        'satuan',
        'harga_satuan',
        'jumlah',
    ];

    protected $casts = [
        'volume' => 'decimal:2',
        'harga_satuan' => 'decimal:2',
        'jumlah' => 'decimal:2',
    ];

    public function rab()
    {
        return $this->belongsTo(Rab::class);
    }
}
