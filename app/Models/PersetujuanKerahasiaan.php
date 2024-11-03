<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class PersetujuanKerahasiaan extends Model
{
    use HasFactory;
    protected $table = 't_persetujuan_assesmen', $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function kelompokAsesor()
    {
        return $this->belongsTo(KelompokAsesor::class,'kelompok_asesor_id');
    }

    public function asesi()
    {
        return $this->belongsTo(Asesi::class,'asesi_id');
    }
}
