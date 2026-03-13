<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budidaya extends Model
{
    use HasFactory;

    protected $fillable = [
        'rumah_id', 'kategori_id', 'nama_budidaya', 'jumlah', 'satuan'
    ];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}