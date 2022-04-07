<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAkun extends Model
{
    use HasFactory;

    public function KlasifikasiAkun()
    {
        return $this->hasMany(KlasifikasiAkun::class);
    }
}
