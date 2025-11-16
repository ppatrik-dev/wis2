<?php

namespace Modules\Term\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Term\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $this->authorize('viewAny', Room::class);
        $rooms = Room::orderby('created_at', 'desc')->paginate(10);
        return view('term::room.index', ["rooms" => $rooms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $this->authorize('create', Room::class);
        return view('term::room.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer', 'min:1'],
        ]);

        $room = Room::create($validated);

        return redirect()->route('room.index')->with('success', 'Room created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        $this->authorize('view', Room::class);
        $room = Room::findOrFail($id);

        return view('term::room.show', ["room" => $room]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        $this->authorize('update', Room::class);
        $room = Room::findOrFail($id);

        return view('term::room.edit', ["room" => $room]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        $this->authorize('update', Room::class);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer', 'min:1'],
        ]);

        $room = Room::findOrFail($id);
        $room->update($validated);

        return redirect()->route('room.index')->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $this->authorize('delete', Room::class);
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('room.index')->with('success', 'Room deleted successfully!');
    }
}
