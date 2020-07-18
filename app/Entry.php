<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $fillable = ['entryNo', 'title', 'report_id', 'type', 'seriesTitle', 'issue',
            'publicationYear', 'place', 'startingYear', 'finishingYear', 'abstract'];

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
