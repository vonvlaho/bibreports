<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Author extends Model
{
    use searchable;
    protected $fillable = ['familyName', 'givenName', 'gender'];

    public function entries ()
    {
        return $this->belongsToMany(Entry::class);
    }

}
