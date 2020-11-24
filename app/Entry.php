<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{

    protected $fillable = ['entryNo', 'fullTitle', 'title', 'report_id', 'type', 'seriesTitle', 'issue',
            'publicationYear', 'place', 'startingYear', 'finishingYear', 'finishedYear', 'abstract'];

    public  function report()
    {
        return $this->belongsTo(Report::Class);
    }
    public function people()
    {
        return $this->belongsToMany(Person::class)->withPivot('role');
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
