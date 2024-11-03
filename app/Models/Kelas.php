<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\FuncCall;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'm_kelas', $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function kelompokAsesor()
    {
        return $this->hasMany(KelompokAsesor::class,'kelas_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class,'jurusan_id');
    }

    public function asesi()
    {
        return $this->hasMany(Asesi::class,'kelas_id');
    }

}
