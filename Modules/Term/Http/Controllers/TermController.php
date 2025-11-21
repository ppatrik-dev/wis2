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

        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $courses = Course::pluck('code')->toArray();
        } else {
            $guarantorCourses = Course::where('guarantor_id', $user->id)->get();
            $lecturerCourses = Course::whereHas('terms', function ($q) use ($user) {
                $q->where('lecturer_id', $user->id);
            })->get();

            $studentCourses = Course::whereHas('terms', function ($termQuery) use ($user) {
                $termQuery->whereHas('termStudents', function ($tsQuery) use ($user) {
                    $tsQuery->where('student_id', $user->id);
                });
            })->get();

            $courses = $guarantorCourses->merge($lecturerCourses)->merge($studentCourses)
                ->unique('id')->pluck('code');
            dd($courses);
        }

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
            "terms" => $terms,
            "query" => $query,
            "types" => $types,
            "type" => $type,
            "courses" => $courses,
            "course" => $course
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $this->authorize('create', Term::class);
        $rooms = Room::all()->pluck('name', 'id')->toArray();
        if (auth()->user()->hasRole('admin')) {
            $courses = Course::pluck('name', 'id')->toArray();
        } else {
            $courses = Course::where('guarantor_id', Auth::id())->pluck('name', 'id')->toArray();
        }

        $courseModels = Course::with('lecturers')
            ->whereIn('id', array_keys($courses))
            ->get();

        $allLecturers = [];

        foreach ($courseModels as $course) {
            foreach ($course->lecturers as $lecturer) {
                $allLecturers[$lecturer->id] = $lecturer->full_name;
            }
        }
        return view('term::term.create', ["users" => $allLecturers, "rooms" => $rooms, "courses" => $courses]);
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
            'course_id' => ['required', 'exists:courses,id'],
            'lecturer_id' => ['nullable', 'exists:users,id'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'registration_required' => ['required', 'boolean'],
        ]);

        $term = Term::create($validated);

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
        $rooms = Room::all()->pluck('name', 'id')->toArray();
        if (auth()->user()->hasRole('admin')) {
            $courses = Course::pluck('name', 'id')->toArray();
        } else {
            $courses = Course::where('guarantor_id', Auth::id())->pluck('name', 'id')->toArray();
        }

        $courseModels = Course::with('lecturers')
            ->whereIn('id', array_keys($courses))
            ->get();

        $allLecturers = [];

        foreach ($courseModels as $course) {
            foreach ($course->lecturers as $lecturer) {
                $allLecturers[$lecturer->id] = $lecturer->full_name;
            }
        }
        $this->authorize('update', $term);
        return view('term::term.edit', ["term" => $term, "users" => $allLecturers, "rooms" => $rooms, "courses" => $courses]);
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
            'course_id' => ['required', 'exists:courses,id'],
            'lecturer_id' => ['nullable', 'exists:users,id'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'registration_required' => ['required', 'boolean'],
        ]);

        $term = Term::findOrFail($id);
        $this->authorize('update', $term);
        $term->update($validated);

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
