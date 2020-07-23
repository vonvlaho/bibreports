<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['title', 'year', 'editor', 'publisher', 'cover'];

    public function entries ()
    {
        return $this->hasMany(Entry::Class);
    }
}
