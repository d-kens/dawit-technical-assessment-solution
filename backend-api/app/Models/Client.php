<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'marital_status',
        'date_of_birth',
        'approval_status'
    ];

    
}




