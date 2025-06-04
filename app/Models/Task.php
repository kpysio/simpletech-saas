<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['client_id', 'title', 'category', 'due_date', 'status'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
