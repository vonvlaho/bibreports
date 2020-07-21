<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Entry extends model
{
    use searchable;

    protected $fillable = ['entryno', 'title', 'report_id', 'type', 'seriestitle', 'issue',
            'publicationyear', 'place', 'startingyear', 'finishingyear', 'finishedyear', 'abstract'];

    public  function report()
    {
        return $this->belongsto(report::class);
    }
    public function authors()
    {
        return $this->belongstomany(author::class);
    }
    public function entries()
    {
        return $this->belongstomany(entry::class);
    }
    public function keywords()
    {
        return $this->belongstomany(keyword::class);
    }
}
