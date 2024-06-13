<?php

namespace App\Http\Controllers;

use App\Models\Airing;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Showing;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AiringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $airings = Airing::with(['cinema', 'room', 'showing'])->get();



        $airings = Airing::with('showing','cinema')->get();


        return view('admin.airing.index', compact('airings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cinemas = Cinema::all();
        $showings = Showing::where('active', true)->with('movie')->get();
        $rooms = Room::all();
        return view('admin.airing.create',compact('cinemas','showings', 'rooms'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'cinema_id' => 'required|integer',
            'showing_id' => 'required|integer',
            'room_id' => 'required|integer',
            'time' => 'required|date_format:Y-m-d\TH:i',
            'price' => 'required|integer|min:0'
        ]);

        $showing = Showing::findOrFail($request->showing_id);
        $movieDuration = $showing->movie->duration;

        list($hours, $minutes) = explode(':', $movieDuration);
        $totalMinutes = ($hours * 60) + $minutes;

        $startTime = Carbon::createFromFormat('Y-m-d\TH:i', $request->time);
        $endTime = $startTime->copy()->addMinutes($totalMinutes);
        $day = $startTime->toDateString();

        // Provera da li je u periodu prikazivanja filma
        if ($startTime <= $showing->from_date || $endTime >= $showing->to_date) {
            return redirect()->route('airings.create')
                ->with('error', 'The selected time is not within the showing period for this movie.');
        }

        // Provera preklapanja sa vec postojecim emitovanjima
        $overlappingAiring = Airing::where('cinema_id', $request->cinema_id)
            ->where('room_id', $request->room_id)
            ->where('day', $day)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($query) use ($startTime, $endTime) {
                    $query->whereBetween('startTime', [$startTime, $endTime])
                        ->orWhereBetween('endTime', [$startTime, $endTime])
                        ->orWhere(function ($query) use ($startTime, $endTime) {
                            $query->where('startTime', '<', $startTime)
                                ->where('endTime', '>', $endTime);
                        });
                });
            })
            ->exists();

        if ($overlappingAiring) {
            return redirect()->route('airings.create')
                ->with('error', 'Another movie is already airing in this room at this time.');
        }

        // Kreiranje emitovanja
        Airing::create([
            'cinema_id' => $request->cinema_id,
            'showing_id' => $request->showing_id,
            'room_id' => $request->room_id,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'day' => $day,
            'price' => $request->price
        ]);

        return redirect()->route('airings.index')->with('success', 'Airing has been added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.airing.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.airing.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $airing = Airing::findOrFail($id);

        $airing->delete();

        return redirect()->route('airings.index')->with('success', 'Airing deleted successfully');
    }

    public function occupiedTimes(Request $request)
    {
        $date = $request->input('date');
        $roomId = $request->input('room_id');

        $occupiedTimes = Airing::where(['day' => $date, 'room_id' => $roomId])
            ->get(['startTime', 'endTime']);

        return response()->json($occupiedTimes);
    }
}
