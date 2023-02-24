<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    
    protected $fillable = [
        'job_title', 'email', 'name', 'registered_since', 'phone','created_at','updated_at'
    ];
}
