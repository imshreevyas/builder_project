<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    use HasFactory;
    protected $fillable = [
        'package_name',
        'duration',
        'duration_type',
        'client_limit',
        'storage_limit',
        'amount',
        'created_at',
        'updated_at',
        'status'
    ];
}