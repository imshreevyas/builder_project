<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'user_id',
        'property_id',
        'emi_count',
        'emi_amount',
        'due_date',
        'transaction_id',
        'remarks',
        'status',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}