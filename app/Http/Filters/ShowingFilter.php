<?php

namespace App\Http\Filters;

class ShowingFilter extends Filter
{
	protected array $filterable = [
		'search',
        'selected_date',
        'selected_cinema',
		'sort'
	];

	protected array $sortable = [
		'movie',
        'name'
	];

	public function search($value = null): void
	{
		if ($value) {
			$this->builder
				->where('movies.name', 'like', "%{$value}%");
		}
	}

    public function selected_date($value = null): void
    {
        if($value) {
            $this->builder
                ->whereHas('airings', function ($query) use ($value) {
                    $query->where('day', $value);
                });
        }
    }

    public function selected_cinema($value = null): void
    {
        if($value && $value != 'all') {
            $this->builder
                ->whereHas('airings', function ($query) use ($value) {
                    $query->where('cinema_id', $value);
                });
        }
    }

	public function sort($value = null): void
	{
		if($value) {
			if (str_contains($value, '_')) {
				$exploded = explode("_", $value);
				$sort = $exploded[0];
				$order = $exploded[1];

				if(in_array($sort, $this->sortable) && in_array($order, ['asc', 'desc'])) {
                    if($sort == 'movie') {
                        $this->builder->join('movies', 'movies.id', '=', 'showings.movie_id')->orderBy('movies.name', $order);
                    } else {
                        $this->builder->orderBy($sort, $order);
                    }
				}
			}
		}
	}
}
