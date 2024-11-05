<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Display a listing of the rooms
    public function index()
    {
        $rooms = Room::all();
        return view('program_head.rooms.index', compact('rooms'));
    }

    // Show the form for creating a new room
    public function create()
    {
        return view('program_head.rooms.create');
    }

    // Store a newly created room in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        Room::create($request->all());

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    // Show the form for editing the specified room
    public function edit(Room $room)
    {
        return view('program_head.rooms.edit', compact('room'));
    }

    // Update the specified room in storage
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    // Remove the specified room from storage
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
