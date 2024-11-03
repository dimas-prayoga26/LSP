<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'certificates', $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'asesi_id');
    }

    public function kelompokAsesor()
    {
        return $this->belongsTo(KelompokAsesor::class,'kelompok_asesor_id');
    }
}
