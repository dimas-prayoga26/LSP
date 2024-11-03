<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Asesi extends Model
{
    use HasFactory;
    protected $table = 'm_asesi', $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function userTestTulis()
    {
        return $this->hasMany(UserTestTulis::class, 'asesor_id');
    }

    public function userTestPraktek()
    {
        return $this->hasMany(UserTestPraktek::class, 'asesor_id');
    }

    public function checklistObservasi()
    {
        return $this->hasMany(Observasi::class, 'asesor_id');
    }

    public function persetujuanAssesmen()
    {
        return $this->hasMany(PersetujuanKerahasiaan::class,'asesor_id');
    }

    public function rekamanAssesmen()
    {
        return $this->hasMany(RekamanAssesmen::class,'asesor_id');
    }

    public function frapl01()
    {
        return $this->hasMany(FRAPL01::class,'asesor_id');
    }

    public function frapl02()
    {
        return $this->hasMany(FRAPL02::class,'asesor_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'asesi_id');
    }
}
