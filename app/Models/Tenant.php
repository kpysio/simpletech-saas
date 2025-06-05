<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['type'];

    public function agencies()
    {
        return $this->belongsToMany(Agency::class);
    }

    public function taskTemplates()
    {
        return $this->hasMany(TaskTemplate::class);
    }
}
