<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\klasifikasiAkun;
use App\Models\User;
use App\Models\Master\AkunBank;
use Wuwx\LaravelAutoNumber\AutoNumberTrait;

class Kas extends Model
{
    // ,AutoNumberTrait
    use HasFactory;
    protected $table="kas";
    protected $guarded= [""];


    public function klasifikasi()
    {
        return $this->belongsTo(KlasifikasiAkun::class, 'klasifikasi_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function posting()
    {
        return $this->belongsTo(Posting::class);
    }
    public function akunBank()
    {
        return $this->belongsTo(AkunBank::class, 'akun_bank_id');
    }
    // public function getAutoNumberOptions()
    // {
    //     return [
    //         'no_transaksi' => [
    //             'format' => function() {
    //                 return  $this->branch_id . '' . date('Ymd') . '?';
    //              },
    //             'length' => 5,
    //         ]
    //     ];
    // }
}
