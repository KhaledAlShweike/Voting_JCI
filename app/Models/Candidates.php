<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidates extends Model
{
    use HasFactory;

    public function Media()
{
    return $this->hasMany(Media::class);
}

public function Category()
{
    return $this->belongsTo(Categories::class);
}

public function Vote()
    {
        return $this->hasMany(Votes::class);
    }

}
