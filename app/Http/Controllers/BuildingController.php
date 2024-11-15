<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{

    public function index()
    {
        $buildings = Building::all();
        return view('registrar.buildings.index', compact('buildings'));
    }


    public function create()
    {
        return view('registrar.buildings.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',

        ]);

        Building::create([
            'name' => $request->name,
        ]);

        return redirect()->route('buildings.index')->with('success', 'Building created successfully.');
    }



    public function edit(Building $building)
    {
        return view('registrar.buildings.edit', compact('building'));
    }


    public function update(Request $request, Building $building)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $building->update($request->all());

        return redirect()->route('buildings.index')->with('success', 'Building updated successfully.');
    }


    public function destroy(Building $building)
    {
        $building->delete();

        return redirect()->route('buildings.index')->with('success', 'Building deleted successfully.');
    }
}
