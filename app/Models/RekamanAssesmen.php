<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RekamanAssesmen extends Model
{
    use HasFactory;
    protected $table = 't_rekaman_assesmen', $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function asesor()
    {
        return $this->belongsTo(Asesor::class,'asesor_id');
    }

    public function asesi()
    {
        return $this->belongsTo(Asesi::class,'asesi_id');
    }

    public function skema()
    {
        return $this->belongsTo(Skema::class,'skema_id');
    }
}
