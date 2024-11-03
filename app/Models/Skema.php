<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Skema extends Model
{
    use HasFactory;
    protected $table = 'm_skema', $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function event()
    {
        return $this->hasMany(KelompokAsesor::class,'skema_id');
    }

    public function berkasPermohonan()
    {
        return $this->hasMany(BerkasPemohon::class,'skema_id');
    }

    public function unitKompetensi()
    {
        return $this->hasMany(UnitKompetensi::class,'skema_id');
    }

    public function testPraktek()
    {
        return $this->hasOne(TestPraktek::class,'skema_id');
    }
}
