<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'user_id',
        'property_id',
        'emi_count',
        'emi_amount',
        'due_date',
        'map_id',
        'transaction_id', 
        'remark',
        'status',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}