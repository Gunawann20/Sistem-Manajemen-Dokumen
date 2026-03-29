<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'user_id',
        'agenda_id',
        'nama_dokumen',
        'jenis_dokumen',
        'tahun',
        'pelaksana',
        'kode_ro',
        'jumlah_anggaran',
        'nama_verifikator',
        'tanggal_sp2d',
        'file_path',
        'file_type',
        'ukuran_file',
        'status',
        'keterangan',
        'admin_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
