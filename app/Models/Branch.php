<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'agency_id'];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
