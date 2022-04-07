<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Master\AkunBank;
use App\Models\Master\PemeriksaKas;
use App\Models\Master\jenisKas;

class CashOpname extends Model
{
    use HasFactory;

    protected $guarded= [""];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function akunBank()
    {
        return $this->belongsTo(AkunBank::class, 'akun_bank_id');
    }
    public function pemeriksa()
    {
        return $this->belongsTo(PemeriksaKas::class, 'pemeriksa_kas_id');
    }
    public function jenis()
    {
        return $this->belongsTo(jenisKas::class, 'jenis_kas_id');
    }
}
