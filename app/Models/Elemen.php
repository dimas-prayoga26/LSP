<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Elemen extends Model
{
    use HasFactory;
    protected $table = 'm_elemen', $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function unitKompetensi()
    {
        return $this->belongsTo(UnitKompetensi::class, 'unit_kompetensi_id');
    }

    public function kriteriaUnjukKerja()
    {
        return $this->hasMany(KriteriaUnjukKerja::class, 'elemen_id');
    }

    public function checklistObservasi()
    {
        return $this->hasMany(Observasi::class, 'elemen_id');
    }
}
