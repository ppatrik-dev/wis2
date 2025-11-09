<?php

namespace Modules\Term\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Term\Models\Term;
use Modules\Term\Models\Room;
use Modules\Course\Models\Course;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $terms = Term::orderBy('created_at', 'desc')->paginate(10);
        return view('term::term.index', ["terms" => $terms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::orderBy('capacity', 'asc');
        $courses = Course::orderBy('created_at', 'desc');
        return view('term::term.create', ["rooms" => $rooms, "courses" => $courses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $term = Term::findOrFail($id);
        return view('term::term.show', ["term" => $term]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $term = Term::findOrFail($id);
        $rooms = Room::orderBy('capacity', 'asc');
        $courses = Course::orderBy('created_at', 'desc');
        return view('term::term.edit', ["term" => $term, "rooms" => $rooms, "courses" => $courses]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $term = Term::findOrFail($id);
        $term->delete();

        return redirect()->route('term.index')->with('success', 'User deleted successfully!');
    }
}
