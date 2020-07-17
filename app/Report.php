<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function entries ()
    {
        return $this->hasMany(Entry::Class);
    }
}
