<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasifikasiAkun extends Model
{
    use HasFactory;

    protected $guarded = [""];
    public function MasterAkun()
    {
        return $this->belongsTo(MasterAkun::class);
    }

}
