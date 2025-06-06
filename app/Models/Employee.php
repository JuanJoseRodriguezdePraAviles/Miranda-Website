<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';

    protected $fillable = ['dni', 'name', 'email', 'password', 'jobFunctions', 'registrationDate', 'phone', 'schelude', 'status'];

    public $timestamps = true;
}
