<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class UnitKompetensi extends Model
{
    use HasFactory;
    protected $table = 'm_unit_kompetensi', $guarded = ['id'];

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

    public function elemen()
    {
        return $this->hasMany(Elemen::class, 'unit_kompetensi_id');
    }

    public function testTulis()
    {
        return $this->hasMany(TestTulis::class,'unit_kompetensi_id');
    }
}
