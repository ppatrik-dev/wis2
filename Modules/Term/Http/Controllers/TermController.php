<?php

namespace Modules\Term\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\User\Models\User;
use Modules\Term\Models\Term;
use Modules\Term\Models\Room;
use Modules\Course\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class TermController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $this->authorize('viewAny', Term::class);

        $types = Term::query()
            ->distinct('type')
            ->pluck('type')
            ->sortDesc();

        $courses = Auth::user()->courses->pluck('code');

        $query = $request['query'];
        $type = $request['type'];
        $course = $request['course'];

        $terms = Term::query()
            ->where('name', 'like', "%{$query}%")
            ->when($type, function ($q, $type) {
                $q->where('type', $type);
            })
            ->when($course, function ($q, $course) {
                $q->whereHas('course', function ($q2) use ($course) {
                    $q2->where('code', $course);
                });
            })
            ->paginate(10);

        return view('term::term.index', [
            "terms" => $terms, "query" => $query, 
            "types" => $types, "type" => $type,
            "courses" => $courses, "course" => $course
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $this->authorize('create', Term::class);
        $users = User::all()->mapWithKeys(fn($user) => [$user->id => $user->getFullNameAttribute()])->toArray();
        $rooms = Room::all()->pluck('name', 'id')->toArray();
        if (auth()->user()->hasRole('admin')) {
            $courses = Course::pluck('name', 'id')->toArray();
        } else {
            $courses = Course::where('guarantor_id', Auth::id())->pluck('name', 'id')->toArray();
        }

        return view('term::term.create', ["users" => $users, "rooms" => $rooms, "courses" => $courses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $this->authorize('create', Term::class);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:lecture,exercise,exam,assignment'],
            'start_at' => ['required', 'date', 'after_or_equal:today'],
            'end_at' => ['required', 'date', 'after_or_equal:today'],
            'max_score' => ['required', 'integer', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'course' => ['required', 'exists:courses,id'],
            'lecturer' => ['nullable', 'exists:users,id'],
            'room' => ['nullable', 'exists:rooms,id'],
            'registration_required' => ['required', 'boolean'],
        ]);

        $term = Term::create([
            'name' => ucfirst($validated['name']),
            'type' => $validated['type'],
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],
            'max_score' => $validated['max_score'],
            'capacity' => $validated['capacity'],
            'description' => $validated['description'] ?? null,
            'course_id' => $validated['course'],
            'lecturer_id' => $validated['lecturer'] ?? null,
            'room_id' => $validated['room'] ?? null,
            'registration_required' => $validated['registration_required'],
        ]);

        $user = User::findOrFail(($validated['lecturer']));
        $user->assignRole('lecturer');

        return redirect()->route('term.index')->with('success', 'Term created successfuly!');
    }

    /**
     * Show the specified resource.
     */
    public function show($id) {
        $term = Term::findOrFail($id);
        $this->authorize('view', $term);
        return view('term::term.show', ["term" => $term]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        $term = Term::findOrFail($id);
        $users = User::all()->mapWithKeys(fn($user) => [$user->id => $user->getFullNameAttribute()])->toArray();
        $rooms = Room::all()->pluck('name', 'id')->toArray();
        $courses = Course::all()->pluck('name', 'id')->toArray();
        $this->authorize('update', $term);
        return view('term::term.edit', ["term" => $term, "users" => $users, "rooms" => $rooms, "courses" => $courses]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:lecture,exercise,exam,assignment'],
            'start_at' => ['required', 'date', 'after_or_equal:today'],
            'end_at' => ['required', 'date', 'after_or_equal:today'],
            'max_score' => ['required', 'integer', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'course' => ['required', 'exists:courses,id'],
            'lecturer' => ['nullable', 'exists:users,id'],
            'room' => ['nullable', 'exists:rooms,id'],
            'registration_required' => ['required', 'boolean'],
        ]);

        $term = Term::findOrFail($id);
        $this->authorize('update', $term);
        $term->update([
            'name' => ucfirst($validated['name']),
            'type' => $validated['type'],
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],
            'max_score' => $validated['max_score'],
            'capacity' => $validated['capacity'],
            'description' => $validated['description'] ?? null,
            'course_id' => $validated['course'],
            'lecturer_id' => $validated['lecturer'] ?? null,
            'room_id' => $validated['room'] ?? null,
            'registration_required' => $validated['registration_required'],
        ]);

        $user = User::findOrFail(($validated['lecturer']));
        $user->assignRole('lecturer');

        return redirect()->route('term.index')->with('success', 'Term updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $term = Term::findOrFail($id);
        $this->authorize('delete', $term);
        $term->delete();
        return redirect()->route('term.index')->with('success', 'Term deleted successfully!');
    }
}
