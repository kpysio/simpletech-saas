<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = ['name', 'industry_type', 'created_by'];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function tenants()
    {
        return $this->belongsToMany(Tenant::class);
    }

    public function taskTemplates()
    {
        return $this->hasMany(TaskTemplate::class);
    }
}
