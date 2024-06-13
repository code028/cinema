<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cinemas = Cinema::all();
        $count = Cinema::count();
        return view('admin.cinema.index', compact('cinemas','count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cinema.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
        ]);

        $cinemas = Cinema::all();
        foreach($cinemas as $cinema){
            $cinemaName = Str::lower($cinema->name);
            $cinemaNameFormated = str_replace(' ','',$cinemaName);
            $nameFromRequest = Str::lower($request->name);
            $nameFromRequestFormated = str_replace(' ','',$nameFromRequest);
            if($nameFromRequestFormated == $cinemaNameFormated){
                return redirect()->route('cinemas.create')->with('error', 'The cinema already exists');
            }
        }

        Cinema::create([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('dashboard')->with('success', 'Cinema created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cinema = Cinema::where('id', $id)->get()->first();
        return view('admin.cinema.show', compact('cinema'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cinema = Cinema::where('id', $id)->get()->first();
        return view('admin.cinema.edit', compact('cinema'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
        ]);

        $cinema = Cinema::findOrFail($id);
        $cinema->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Cinema updated successfully');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cinema = Cinema::findOrFail($id);

        $cinema->delete();

        return redirect()->route('dashboard')->with('success', 'Cinema deleted successfully');
    }
}
