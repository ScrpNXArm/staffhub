<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'head_id',
        'is_active',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}