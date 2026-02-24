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
        'file_path',
        'file_type',
        'ukuran_file',
        'status',
        'keterangan',
        'tahun',
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
