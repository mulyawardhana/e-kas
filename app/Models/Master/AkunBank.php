<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AkunBank extends Model
{
    use HasFactory;
    protected $guarded=[""];
    public function user()
    {
        return $this->belongsToMany(User::class, 'users_akuns','user_id','akun_bank_id');
    }
    public function kas()
    {
        return $this->hasMany(Kas::class);
    }
    public function mbranch()
    {
        return $this->belongsToMany(MBranch::class, 'akun_branchs','branch_id','akun_bank_id');
    }
}
