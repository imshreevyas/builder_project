<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_name',
        'address',
        'description',
        'created_at',
        'updated_at',
        'status'
    ];
    public function Documents(): HasMany
    {
        return $this->HasMany(Documents::class);
    }

    
}