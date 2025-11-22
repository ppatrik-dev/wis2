<?php
/**
 * @file RoomController.php
 * @author Patrik Procházka (xprochp00@vutbr.cz)
 * @brief Controller for managing rooms in the Room module
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

namespace Modules\Term\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Term\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller {
    /**
     * Display a listing of the rooms.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request) {
        $this->authorize('viewAny', Room::class);

        $query = $request['query'];

        $rooms = Room::query()
            ->where('name', 'like', "%{$query}%")
            ->paginate(10);

        return view('term::room.index', ["rooms" => $rooms, "query" => $query]);
    }

    /**
     * Show the form for creating a new room.
     *
     * @return void
     */
    public function create() {
        $this->authorize('create', Room::class);
        return view('term::room.create');
    }

    /**
     * Store a newly created room in storage.
     *
     * @param Request $request
     * @return void
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
     * Display the specified room.
     *
     * @param [type] $id
     * @return void
     */
    public function show($id) {
        $this->authorize('view', Room::class);
        $room = Room::findOrFail($id);

        return view('term::room.show', ["room" => $room]);
    }

    /**
     * Show the form for editing the specified room.
     *
     * @param [type] $id
     * @return void
     */
    public function edit($id) {
        $this->authorize('update', Room::class);
        $room = Room::findOrFail($id);

        return view('term::room.edit', ["room" => $room]);
    }

    /**
     * Update the specified room in storage.
     *
     * @param Request $request
     * @param [type] $id
     * @return void
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
     * Remove the specified room from storage.
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id) {
        $this->authorize('delete', Room::class);
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('room.index')->with('success', 'Room deleted successfully!');
    }
}
