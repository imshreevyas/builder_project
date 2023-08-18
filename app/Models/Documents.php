<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory;
    protected $table = 'documents';
    protected $fillable = [
        'property_id',
        'document_name',
        'document_url'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}