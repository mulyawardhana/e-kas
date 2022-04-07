<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MBranch extends Model
{
    use HasFactory;
    protected $guarded=[""];
    public function akunBank()
    {
        return $this->belongsToMany(AkunBank::class, 'akun_branchs','branch_id','akun_bank_id');
    }
}
