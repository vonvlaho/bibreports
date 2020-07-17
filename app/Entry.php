<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    public  function report()
    {
        return $this->belongsTo(Report::Class);
    }
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
    public function entries()
    {
        return $this->belongsToMany(Entry::class);
    }
    public function keywords()
    {
        return $this->belongsToMany(Keyword::Class);
    }
}
