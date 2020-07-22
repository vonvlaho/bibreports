<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Entry extends Model
{
    use Searchable;

    protected $fillable = ['entryNo', 'title', 'report_id', 'type', 'seriesTitle', 'issue',
            'publicationYear', 'place', 'startingYear', 'finishingYear', 'finishedYear', 'abstract'];

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
