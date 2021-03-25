<?php

namespace App\Http\Controllers;

use App\Keyword;
use App\Person;
use App\Place;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class DataController extends Controller
{
    public function keywords()
    {
        $keywords = Keyword::select('id','name')
            ->withCount([
                'entries as total',
                'entries as Y-1966' => function (Builder $query){$query->where('report_id', '1');},
                'entries as Y-1967' => function (Builder $query){$query->where('report_id', '2');},
                'entries as Y-1968' => function (Builder $query){$query->where('report_id', '3');},
                'entries as Y-1969' => function (Builder $query){$query->where('report_id', '4');},
                'entries as Y-1970' => function (Builder $query){$query->where('report_id', '5');},
                'entries as Y-1971' => function (Builder $query){$query->where('report_id', '6');},
                'entries as Y-1972' => function (Builder $query){$query->where('report_id', '7');},
                'entries as Y-1973' => function (Builder $query){$query->where('report_id', '8');},
                'entries as Y-1974' => function (Builder $query){$query->where('report_id', '9');},
                'entries as Y-1975' => function (Builder $query){$query->where('report_id', '10');}])
            ->orderBy('total', 'desc')
            ->get()
            ->toArray();
        return view('data.store', ['items' => $keywords, 'title' => 'Schlagworte']);
    }

    public function places()
    {
        $places = Place::select('id','name')
            ->withCount([
                'entries as total',
                'entries as Y-1966' => function (Builder $query){$query->where('report_id', '1');},
                'entries as Y-1967' => function (Builder $query){$query->where('report_id', '2');},
                'entries as Y-1968' => function (Builder $query){$query->where('report_id', '3');},
                'entries as Y-1969' => function (Builder $query){$query->where('report_id', '4');},
                'entries as Y-1970' => function (Builder $query){$query->where('report_id', '5');},
                'entries as Y-1971' => function (Builder $query){$query->where('report_id', '6');},
                'entries as Y-1972' => function (Builder $query){$query->where('report_id', '7');},
                'entries as Y-1973' => function (Builder $query){$query->where('report_id', '8');},
                'entries as Y-1974' => function (Builder $query){$query->where('report_id', '9');},
                'entries as Y-1975' => function (Builder $query){$query->where('report_id', '10');}])
            ->orderBy('total', 'desc')
            ->get()
            ->toArray();
        return view('data.store', ['items' => $places, 'title' => 'Orte']);
    }
    public function people()
    {
        $people = Person::select(DB::raw("id, CONCAT(givenName, ' ', familyName) AS name"))->withCount([
            'entries as total',
            'entries as Y-1966' => function (Builder $query){$query->where('report_id', '1');},
            'entries as Y-1967' => function (Builder $query){$query->where('report_id', '2');},
            'entries as Y-1968' => function (Builder $query){$query->where('report_id', '3');},
            'entries as Y-1969' => function (Builder $query){$query->where('report_id', '4');},
            'entries as Y-1970' => function (Builder $query){$query->where('report_id', '5');},
            'entries as Y-1971' => function (Builder $query){$query->where('report_id', '6');},
            'entries as Y-1972' => function (Builder $query){$query->where('report_id', '7');},
            'entries as Y-1973' => function (Builder $query){$query->where('report_id', '8');},
            'entries as Y-1974' => function (Builder $query){$query->where('report_id', '9');},
            'entries as Y-1975' => function (Builder $query){$query->where('report_id', '10');}
        ])->orderBy('total', 'desc')->get()->toArray();
        return view('data.store', ['items' => $people, 'title' => 'Personen']);
    }

    public function itemsInPlace($id)
    {
        $keywords = Keyword::select('id','name')
            ->whereHas('entries.places', function (Builder $query) use ($id) {
                $query->where('places.id', '=', $id);
            })
            ->withCount([
                'entries as total' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    });
                },
                'entries as Y-1966' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '1');
                },
                'entries as Y-1967' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '2');
                },
                'entries as Y-1968' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '3');
                },
                'entries as Y-1969' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '4');
                },
                'entries as Y-1970' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '5');
                },
                'entries as Y-1971' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '6');
                },
                'entries as Y-1972' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '7');
                },
                'entries as Y-1973' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '8');
                },
                'entries as Y-1974' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '9');
                },
                'entries as Y-1975' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '10');
                }
            ])->orderBy('total', 'desc')->get()->toArray();

        $people = Person::select(DB::raw("id, CONCAT(givenName, ' ', familyName) AS name"))
            ->whereHas('entries.places', function (Builder $query) use ($id) {
                $query->where('places.id', '=', $id);
            })
            ->withCount([
                'entries as total' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    });
                },
                'entries as Y-1966' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '1');
                },
                'entries as Y-1967' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '2');
                },
                'entries as Y-1968' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '3');
                },
                'entries as Y-1969' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '4');
                },
                'entries as Y-1970' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '5');
                },
                'entries as Y-1971' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '6');
                },
                'entries as Y-1972' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '7');
                },
                'entries as Y-1973' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '8');
                },
                'entries as Y-1974' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '9');
                },
                'entries as Y-1975' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '10');
                }
            ])->orderBy('total', 'desc')->get()->toArray();

        $title = Place::findOrFail($id)->name;

        return view('data.show', ['itemGroup' => ['Schlagworte' => $keywords, 'Personen' => $people], 'title' => $title]);
    }
    public function itemsInKeyword($id)
    {

        $places = Place::select('id','name')
            ->whereHas('entries.keywords', function (Builder $query) use ($id) {
                $query->where('keywords.id', '=', $id);
            })
            ->withCount([
                'entries as total' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    });
                },
                'entries as Y-1966' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '1');
                },
                'entries as Y-1967' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '2');
                },
                'entries as Y-1968' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '3');
                },
                'entries as Y-1969' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '4');
                },
                'entries as Y-1970' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '5');
                },
                'entries as Y-1971' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '6');
                },
                'entries as Y-1972' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '7');
                },
                'entries as Y-1973' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '8');
                },
                'entries as Y-1974' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '9');
                },
                'entries as Y-1975' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '10');
                }
            ])->orderBy('total', 'desc')->get()->toArray();

        $people = Person::select(DB::raw("id, CONCAT(givenName, ' ', familyName) AS name"))
            ->whereHas('entries.keywords', function (Builder $query) use ($id) {
                $query->where('keywords.id', '=', $id);
            })
            ->withCount([
                'entries as total' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    });
                },
                'entries as Y-1966' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '1');
                },
                'entries as Y-1967' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '2');
                },
                'entries as Y-1968' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '3');
                },
                'entries as Y-1969' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '4');
                },
                'entries as Y-1970' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '5');
                },
                'entries as Y-1971' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '6');
                },
                'entries as Y-1972' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '7');
                },
                'entries as Y-1973' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '8');
                },
                'entries as Y-1974' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '9');
                },
                'entries as Y-1975' => function (Builder $query) use ($id) {
                    $query->whereHas('keywords', function (Builder $query) use ($id) {
                        $query->where('keywords.id', '=', $id);
                    })->where('report_id', '10');
                }
            ])->orderBy('total', 'desc')->get()->toArray();

        $title = Keyword::findOrFail($id)->name;

        return view('data.show', ['itemGroup' => ['Orte' => $places, 'Personen' => $people], 'title' => $title]);
    }
    public function itemsInPerson($id)
    {

        $places = Place::select('id','name')
            ->whereHas('entries.people', function (Builder $query) use ($id) {
                $query->where('people.id', '=', $id);
            })
            ->withCount([
                'entries as total' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    });
                },
                'entries as Y-1966' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '1');
                },
                'entries as Y-1967' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '2');
                },
                'entries as Y-1968' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '3');
                },
                'entries as Y-1969' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '4');
                },
                'entries as Y-1970' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '5');
                },
                'entries as Y-1971' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '6');
                },
                'entries as Y-1972' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '7');
                },
                'entries as Y-1973' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '8');
                },
                'entries as Y-1974' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '9');
                },
                'entries as Y-1975' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '10');
                }
            ])->orderBy('total', 'desc')->get()->toArray();

        $keywords = Keyword::select('id','name')
            ->whereHas('entries.people', function (Builder $query) use ($id) {
                $query->where('people.id', '=', $id);
            })
            ->withCount([
                'entries as total' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    });
                },
                'entries as Y-1966' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '1');
                },
                'entries as Y-1967' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '2');
                },
                'entries as Y-1968' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '3');
                },
                'entries as Y-1969' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '4');
                },
                'entries as Y-1970' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '5');
                },
                'entries as Y-1971' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '6');
                },
                'entries as Y-1972' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '7');
                },
                'entries as Y-1973' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '8');
                },
                'entries as Y-1974' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '9');
                },
                'entries as Y-1975' => function (Builder $query) use ($id) {
                    $query->whereHas('people', function (Builder $query) use ($id) {
                        $query->where('people.id', '=', $id);
                    })->where('report_id', '10');
                }
            ])->orderBy('total', 'desc')->get()->toArray();

        $person = Person::findOrFail($id);
        $title = $person->givenName . ' ' . $person->familyName;

        return view('data.show', ['itemGroup' => ['Schlagworte' => $keywords, 'Orte' => $places], 'title' => $title]);
    }
}
