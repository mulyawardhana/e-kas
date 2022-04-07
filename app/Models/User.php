<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Master\AkunBank;
use App\Models\Master\PemeriksaKas;
use App\Models\Master\Jabatan;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $guarded =[""];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posting()
    {
        return $this->belongsTo(Posting::class);
    }
    public function efilling()
    {
        return $this->hasMany(Efilling::class);
    }
    public function akunBank()
    {
        return $this->belongsToMany(akunBank::class, 'users_akuns','user_id','akun_bank_id');
    }
    public function akunBanks()
    {
        return $this->belongsTo(akunBank::class);
    }
    public function pemeriksa()
    {
        return $this->belongsTo(PemeriksaKas::class, 'pemeriksa_kas_id');
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}
