<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KelompokAsesor extends Model
{
    use HasFactory;
    protected $table = 't_kelompok_asesor', $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function skema()
    {
        return $this->belongsTo(Skema::class,'skema_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class,'event_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id');
    }

    public function asesor()
    {
        return $this->belongsTo(Asesor::class,'asesor_id');
    }

    public function frapl01()
    {
        return $this->hasMany(FRAPL01::class,'kelompok_asesor_id');
    }

    public function frapl02()
    {
        return $this->hasMany(FRAPL02::class,'kelompok_asesor_id');
    }

    public function userTestTulis()
    {
        return $this->hasMany(UserTestTulis::class,'kelompok_asesor_id');
    }

    public function userTestPraktek()
    {
        return $this->hasMany(UserTestPraktek::class,'kelompok_asesor_id');
    }

    public function userTestWawancara()
    {
        return $this->hasMany(UserTestWawancara::class,'kelompok_asesor_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'kelompok_asesor_id');
    }
}
