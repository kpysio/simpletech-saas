<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskTemplate extends Model
{
    protected $fillable = ['agency_id', 'tenant_id', 'title', 'category', 'description'];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
