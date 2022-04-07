<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\AkunBank;
use Wuwx\LaravelAutoNumber\AutoNumberTrait;

class Cashbon extends Model
{
    use HasFactory,AutoNumberTrait;
    protected $guarded=[""];
    
    public function akun()
    {
        return $this->belongsTo(AkunBank::class);
    }
    public function getAutoNumberOptions()
    {
        return [
            'no_transaksi' => [
                'format' => function() {
                    return  $this->branch_id . date('ymd') . '?'; 
                 },
                'length' => 5, 
            ]
        ];
    }
}
