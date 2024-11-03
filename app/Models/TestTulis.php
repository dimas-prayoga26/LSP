<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class TestTulis extends Model
{
    use HasFactory;
    protected $table = 'm_test_tulis', $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function kriteriaUnjukKerja()
    {
        return $this->belongsTo(KriteriaUnjukKerja::class,'kriteria_unjuk_kerja_id');
    }

    public function unitKompetensi()
    {
        return $this->belongsTo(UnitKompetensi::class,'unit_kompetensi_id');
    }
}
