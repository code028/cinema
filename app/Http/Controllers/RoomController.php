<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Room;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('cinema')->get();
        return view('admin.room.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cinemas = Cinema::all();
        return view('admin.room.create', compact('cinemas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cinema_id' => 'string|required',
            'name' => 'string|required',
            'capacity' => 'integer|required'
        ]);

        if($request->cinema_id == "0"){
            return redirect()->route('rooms.create')->with('error', 'Please select cinema');
        }

        $roomName = str_replace(' ', '', Str::lower($request->name));

        $existingRoom = Room::where('cinema_id', $request->cinema_id)
                            ->whereRaw("REPLACE(LOWER(name), ' ', '') = ?", [$roomName])
                            ->exists();

        if ($existingRoom) {
            return redirect()->route('rooms.create')->with('error', 'Room with the same name already exists');
        }

        if($request->capacity < 1){
            return redirect()->route('rooms.create')->with('error', 'Capacity must be greater than 0');
        }

        Room::create([
            'cinema_id' => $request->cinema_id,
            'name' => $request->name,
            'capacity' => $request->capacity
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.room.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::with('cinema')->findOrFail($id);
        return view('admin.room.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => 'string|required',
            "capacity" => 'integer|required'
        ]);

        if($request->capacity < 1){
            return redirect()->route('rooms.edit')->with('error', 'Capacity must be greater than 0');
        }

        $room = Room::findOrFail($id);

        $room->update([
            "name" => $request->name,
            "capacity" => $request->capacity
        ]);

        return redirect()->route('rooms.index')->with('success', 'The room has been successfully modified');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);

        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully');
    }

    public function getRoomsByCinema($cinema_id)
    {
        $rooms = Room::where('cinema_id', $cinema_id)->get();
        return response()->json($rooms);
    }
}
