<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    public function entries ()
    {
        return $this->belongsToMany(Entry::Class);
    }
}
