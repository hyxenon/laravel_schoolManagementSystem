<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Building;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    public function index()
    {

        $rooms = Room::all();


        $buildings = Building::all();


        return view('program_head.rooms.index', compact('rooms', 'buildings'));
    }



    public function create()
    {

        $buildings = Building::all();


        return view('program_head.rooms.create', compact('buildings'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'building_id' => 'required|exists:buildings,id',
            'capacity' => 'required|integer|min:1',
        ]);


        Room::create($request->all());

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }


    public function edit(Room $room)
    {
        return view('program_head.rooms.edit', compact('room'));
    }


    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'building_id' => 'required|exists:buildings,id',
            'capacity' => 'required|integer|min:1',
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }


    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
