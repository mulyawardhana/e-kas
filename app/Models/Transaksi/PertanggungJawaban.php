<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi\Cashbon;

class PertanggungJawaban extends Model
{
    use HasFactory;
    protected $table = 'pertanggungjawabans';
    protected $guarded = [""];

    public function kasbon()
    {
        return $this->belongsTo(Cashbon::class);
    }
}
