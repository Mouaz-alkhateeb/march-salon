<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BridePackage extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'bride_packages';
    protected $fillable = ['name'];
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_bride_packages');
    }
}