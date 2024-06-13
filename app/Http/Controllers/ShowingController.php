<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Showing;
use Illuminate\Http\Request;

class ShowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $showings = Showing::all();
        $count = $showings->count();
        return view('admin.showing.index', compact('showings','count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $showings = Showing::all();



        $movies = Movie::leftJoin('showings', 'movies.id', '=', 'showings.movie_id')
                       ->whereNull('showings.id')
                       ->orWhere('showings.active', 0)
                       ->select('movies.*')
                       ->distinct()
                       ->get();

        $moviesCount = Movie::count();
        return view('admin.showing.create', compact('movies','showings','moviesCount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'string|required',
            'name' => 'string|required',
            'from_date' => 'date|required',
            'to_date' => 'date|required',
        ]);

        $isMovieActiveInShowing = Showing::where('movie_id', $request->movie_id)
        ->where('active', 1)
        ->exists();


        if($request->from_date > $request->to_date){
            return redirect()->route('showings.create')->with('error', 'End date of showing cant be younger than start date!');
        }

        if($isMovieActiveInShowing){
            return redirect()->route('showings.create')->with('error', 'Showing for this movie is already active!');
        }

        // All showing which are created will be active, and that protect me from adding new showing for same movie if active is 1
        // Command DeactivateExpiredShowings help me to set active of movie_id to 0 if to_date < than today 👍
        // command >> php artisan showings:deactivate-expired


        // ----------------------------------------------------------------- //
        // $isActive = false;                                                //
        // $today = Carbon::tomorrow()->toDateString();                      //
        // if($today >= $request->from_date && $today <= $request->to_date){ //
        //     $isActive = true;                                             //
        // }                                                                 //
        // ----------------------------------------------------------------- //

        Showing::create([
            "movie_id" => $request->movie_id,
            "name" => $request->name,
            "from_date" => $request->from_date,
            "to_date" => $request->to_date,
            // "active" => $isActive
            "active" => true
        ]);

        return redirect()->route('showings.index')->with('success', 'Showing created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $showing = Showing::findOrFail($id);
        return view('admin.showing.show', compact('showing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $movies = Movie::all();
        $showing = Showing::findOrFail($id);
        return view('admin.showing.edit', compact('movies','showing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            // 'movie_id' => 'required',
            'name' => 'string|required',
            'from_date' => 'date|required',
            'to_date' => 'date|required',
        ]);

        if($request->from_date > $request->to_date){
            return redirect()->route('showings.edit', $id)->with('error', 'End date of showing cant be younger than start date!');
        }

        $showing = Showing::findOrFail($id);

        $showing->update([
            // 'movie_id' => $request->movie_id,
            'name' => $request->name,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'active' => true
        ]);


        return redirect()->route('showings.index')->with('success', 'Showing updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $showing = Showing::findOrFail($id);

        $showing->delete();

        return redirect()->route('showings.index')->with('success', 'Showing deleted successfully');
    }

    public function getShowingPeriod($id)
    {
        $showing = Showing::find($id);

        if ($showing) {
            return response()->json([
                'fromDate' => $showing->from_date,
                'toDate' => $showing->to_date,
            ]);
        } else {
            return response()->json(null, 404);
        }
    }
}
