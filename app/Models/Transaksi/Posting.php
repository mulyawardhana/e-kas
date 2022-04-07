<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Posting extends Model
{
    use HasFactory;
    protected $guarded =[""];

    public function Kas()
    {
        return $this->hasMany(Kas::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
