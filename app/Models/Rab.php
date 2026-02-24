<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rab extends Model
{
    protected $fillable = [
        'user_id',
        'agenda_id',
        'judul_rab',
        'nomor_rab',
        'tanggal_rab',
        'tahun_anggaran',
        'keterangan_rab',
        'total_jumlah',
        'status',
    ];

    protected $casts = [
        'tanggal_rab' => 'datetime',
        'total_jumlah' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function items()
    {
        return $this->hasMany(RabItem::class);
    }
}
