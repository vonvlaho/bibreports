<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = ['familyName', 'givenName', 'gender'];

    public function entries ()
    {
        return $this->belongsToMany(Entry::class);
    }

}
