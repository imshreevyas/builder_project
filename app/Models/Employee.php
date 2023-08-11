<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'firstName',
        'lastName',
        'email',
        'mobile',
        'empCode',
        'department',
        'designation',
        'address',
        'joiningDate',
        'ctc',
    ];
}
