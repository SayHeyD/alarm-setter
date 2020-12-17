<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    use HasFactory;

    protected $fillable = ['recorded', 'recorded_at', 'topLimit', 'bottomLimit'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
