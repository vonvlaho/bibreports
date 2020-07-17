<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function entries ()
    {
        return $this->belongsToMany(Entry::class);
    }

}
