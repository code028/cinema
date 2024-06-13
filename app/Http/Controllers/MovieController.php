<?php

namespace App\Http\Controllers;

use App\Http\Filters\MovieFilter;
use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MovieFilter $filter)
    {
        $movies = Movie::filter($filter)->get();
        $count = $movies->count();
        return view('admin.movie.index', compact('movies', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.movie.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'directors' => 'required|string',
            'writers' => 'required|string',
            'actors' => 'required|string',
            'name' => 'required|string',
            'hours' => 'required|integer|min:0|max:23',
            'minutes' => 'required|integer|min:0|max:59',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'released' => 'required|date',
            'rating' => 'required|numeric|between:1,10',
            'description' => 'required|string',
            'imdb' => 'required|string',
            'trailer' => 'required|string',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id'
        ]);
        $duration = sprintf('%02d:%02d', $request->hours, $request->minutes);

        $imageName = time().'.'.$request->image->extension();

        $movieName = str_replace(' ','_', $request->name);
        $path = '/images/movies/'.$movieName.'/';
        $request->image->move(public_path($path), $imageName);

        $movie = Movie::create([
            'directors' => $request->directors,
            'writers' => $request->writers,
            'actors' => $request->actors,
            'name' => $request->name,
            'duration' => $duration,
            'image' => $path.$imageName,
            'released' => $request->released,
            'rating' => $request->rating,
            'description' => $request->description,
            'imdb' => $request->imdb,
            'trailer' => $request->trailer
        ]);

        $movie->categories()->attach($request->categories);

        return redirect()->route('movies.index')->with('success', 'Movie created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = Movie::where('id', $id)->get()->first();
        $categories = Category::all();
        $movieCategories = $movie->categories;
        return view('admin.movie.show', compact('movie','categories', 'movieCategories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $movie = Movie::where('id', $id)->get()->first();
        $categories = Category::all();
        $movieCategories = $movie->categories->pluck('id')->toArray();

        return view('admin.movie.edit', compact('movie', 'categories', 'movieCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $movie = Movie::findOrFail($id);

        $request->validate([
            'directors' => 'required|string',
            'writers' => 'required|string',
            'actors' => 'required|string',
            'name' => 'required|string',
            'hours' => 'required|integer|min:0|max:23',
            'minutes' => 'required|integer|min:0|max:59',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'released' => 'required|date',
            'rating' => 'required|numeric|between:1,10',
            'description' => 'required|string',
            'imdb' => 'required|string',
            'trailer' => 'required|string',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id'
        ]);

        $duration = sprintf('%02d:%02d', $request->hours, $request->minutes);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $movieName = str_replace(' ','_', $request->name);
            $path = '/images/movies/'.$movieName.'/';
            $request->image->move(public_path($path), $imageName);
            $imagePath = $path.$imageName;
        } else {
            // If no new image is uploaded, keep the existing image
            $imagePath = $movie->image;
        }

        $movie->update([
            'directors' => $request->directors,
            'writers' => $request->writers,
            'actors' => $request->actors,
            'name' => $request->name,
            'duration' => $duration,
            'image' => $imagePath,
            'released' => $request->released,
            'rating' => $request->rating,
            'description' => $request->description,
            'imdb' => $request->imdb,
            'trailer' => $request->trailer
        ]);

        $movie->categories()->sync($request->categories);

        return redirect()->route('movies.index')->with('success', 'Movie updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cinema = Movie::findOrFail($id);

        $cinema->delete();

        return redirect()->route('movies.index')->with('success', 'Movie deleted successfully');
    }
}
