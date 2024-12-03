<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Get the page number from the query parameters (default to page 1)
        $page = $request->get('page', 1);

        // Retrieve 10 events per page, ordered by 'added_at' in descending order (newest first)
        $events = Event::orderBy('added_at', 'desc')->paginate(10);

        return view('events.index', compact('events'));
    }


    // Show the form to create a new event
    public function create()
    {
        return view('events.create'); // Return the view for creating an event
    }

    // Store a new event in the database
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'meeting' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'date' => 'required|date',
            'status' => 'required|in:Active,Postponed,Completed,Canceled',
            'department' => 'required|string',
            'expected_attendee' => 'required|string',
            'requested_by' => 'required|string',
        ]);

        // Create the event (added_at is automatically set by the model)
        Event::create([
            'meeting' => $request->meeting,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'date' => $request->date,
            'status' => $request->status,
            'department' => $request->department,
            'expected_attendees' => $request->expected_attendee,
            'requested_by' => $request->requested_by,
            // No need to include 'added_at' in the array because it's handled automatically
        ]);

        return redirect()->route('events.index')->with('success', 'Meeting added successfully!');
    }


    // Show the form to edit an event
    public function edit($eventId)
    {
        // Find the event by ID
        $event = Event::find($eventId);

        if (!$event) {
            return redirect()->route('events.index')->with('error', 'Event not found!');
        }

        // Return the view with the event data
        return view('events.edit', compact('event'));
    }

    // Update the event in the database
    public function update(Request $request, $eventId)
{
    // Find the event by ID or fail
    $event = Event::findOrFail($eventId);

    // Validate the incoming data
    $validated = $request->validate([
        'meeting' => 'required|string',
        'start_time' => 'required|date_format:H:i|before:end_time',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'date' => 'required|date',
        'status' => 'required|in:Active,Postponed,Completed,Canceled',
        'department' => 'required|string',
        'expected_attendees' => 'required|string', // corrected field name
        'requested_by' => 'required|string',
    ]);

    // Update the event with the validated data
    $event->update($validated);

    // Redirect back to the events index with a success message
    return redirect()->route('events.index')->with('success', 'Meeting updated successfully!');
}


    // Delete an event from the database
    public function destroy($eventId)
    {
        try {
            // Find the event by its ID
            $event = Event::find($eventId);

            if (!$event) {
                // If the event doesn't exist, return a 404 response
                return response()->json(['success' => false, 'message' => 'Event not found'], 404);
            }

            // Proceed with deletion
            $event->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    // Show a specific event's details
    public function show($eventId)
    {
        try {
            $event = Event::findOrFail($eventId); // Find event by ID or throw 404
            return response()->json(['success' => true, 'event' => $event]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Event not found'], 404);
        }
    }
}
