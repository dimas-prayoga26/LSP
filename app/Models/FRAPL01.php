<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FRAPL01 extends Model
{
    use HasFactory;
    protected $table = 't_frapl01', $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function asesi()
    {
        return $this->belongsTo(Asesi::class,'asesi_id');
    }

    public function kelompokAsesor()
    {
        return $this->belongsTo(KelompokAsesor::class,'kelompok_asesor_id');
    }
}
