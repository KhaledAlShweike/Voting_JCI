<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidates extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name', 'last_name', 'position', 'last_position', 'jci_career', 'category_id'
    ];
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
