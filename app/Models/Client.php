<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\Branch;
use App\Models\User;
use App\Models\Client;
use App\Models\Task;


class Client extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'phone', 'employee_id', 'department'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
