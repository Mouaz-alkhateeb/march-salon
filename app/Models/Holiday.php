<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'expert_id'];

    public function expert()
    {
        return $this->belongsTo(Expert::class, 'expert_id');
    }
}
