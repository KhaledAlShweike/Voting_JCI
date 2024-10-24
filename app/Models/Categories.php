<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $fillable=[
        'name'
    ];

    public function Candidate()
    {
        return $this->hasMany(Candidates::class);
    }

    public function Vote()
    {
        return $this->hasMany(Vote::class);
    }
}
