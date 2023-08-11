<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = [
        'valid_till',
        'user_id',
        'company_name',
        'machine_name',
        'serial_number',
        'machine_details',
    ];
}