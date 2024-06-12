<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'date',
    ];

    // Аксессор для получения даты в формате d.m.Y
    public function getDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d.m.Y');
    }

    // Мутатор для сохранения даты в формате Y-m-d
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $value)->format('Y-m-d');
    }
}
