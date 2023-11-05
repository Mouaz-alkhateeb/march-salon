<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expert extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'position',
        'image',
    ];
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_experts');
    }

    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
