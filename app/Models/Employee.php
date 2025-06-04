<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\Branch;
use App\Models\User;
use App\Models\Client;
    

class Employee extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['user_id', 'branch_id', 'department'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
    
}
