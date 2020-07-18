<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['familyName', 'givenName', 'gender'];

    public function entries ()
    {
        return $this->belongsToMany(Entry::class);
    }

}
