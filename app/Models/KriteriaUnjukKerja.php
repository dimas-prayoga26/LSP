<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class KriteriaUnjukKerja extends Model
{
    use HasFactory;
    protected $table = 'm_kriteria_unjuk_kerja', $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function testTulis()
    {
        return $this->hasMany(TestTulis::class, 'kriteria_unjuk_kerja_id');
    }

    public function elemen()
    {
        return $this->belongsTo(Elemen::class, 'elemen_id');
    }
}
