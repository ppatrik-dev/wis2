<?php

namespace Modules\Course\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Course\App\Services\CourseLecturerService;
use Modules\User\Models\User;
use Illuminate\View\View;

class CourseLecturerController extends Controller
{
    private $courseLecturerService;

    public function __construct(CourseLecturerService $courseLecturerService)
    {
        $this->courseLecturerService = $courseLecturerService;
    }

    /**
     * Display a listing of course lecturers for a specific course
     */
    public function index(Request $request, int $courseId)
    {
        $courseLecturers = $this->courseLecturerService->getByCourse($courseId);
        return view('course::course_lecturer.index', compact('courseLecturers', 'courseId'));
    }

    /**
     * Show the form for creating a new course lecturer
     */
    public function create(int $courseId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $course = \Modules\Course\Models\Course::findOrFail($courseId);

        // Only admin or the guarantor of the course may add lecturers
        if (!($user->hasRole('admin') || $course->guarantor_id === $user->id)) {
            abort(403, 'Unauthorized');
        }

        $users = User::select('id', 'first_name', 'last_name')
            ->orderBy('created_at', 'desc')
            ->get()->mapWithKeys(fn($user) => [$user->id => "{$user->first_name} {$user->last_name}"])
            ->toArray();
        return view('course::course_lecturer.create', compact('courseId', 'users'));
    }

    /**
     * Store a newly created course lecturer
     */
    public function store(Request $request, int $courseId)
    {
        $validated = $request->validate([
            'lecturer_id' => ['required', 'exists:users,id'],
        ]);
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $course = \Modules\Course\Models\Course::findOrFail($courseId);

        if (!($user->hasRole('admin') || $course->guarantor_id === $user->id)) {
            abort(403, 'Unauthorized');
        }

        try {
            $courseLecturer = $this->courseLecturerService->addLecturer(
                $courseId,
                $validated['lecturer_id']
            );
            // After adding lecturer, ensure the user has the 'lecturer' role unless they are admin/guarantor
            $targetUser = User::find($validated['lecturer_id']);
            if ($targetUser) {
                $highest = $targetUser->getHighestRole();
                if (!in_array($highest, ['admin', 'guarantor'], true)) {
                    // Replace existing lower roles with only 'lecturer'
                    $targetUser->syncRoles(['lecturer']);
                }
            }

            return redirect()->route('course.lecturer.index', $courseId)
                ->with('success', 'Lecturer added to course successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error adding lecturer: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified course lecturer
     */
    public function show(int $courseId, int $lecturerId)
    {
        $courseLecturer = $this->courseLecturerService->getByCourseAndLecturer($courseId, $lecturerId);
        return view('course::course_lecturer.show', compact('courseLecturer', 'courseId', 'lecturerId'));
    }

    /**
     * Show the form for editing the specified course lecturer
     */
    public function edit(int $courseId, int $lecturerId): View
    {
        $courseLecturer = $this->courseLecturerService->getByCourseAndLecturer($courseId, $lecturerId);
        return view('course::course_lecturer.edit', compact('courseLecturer', 'courseId', 'lecturerId'));
    }

    /**
     * Update the specified course lecturer
     */
    public function update(Request $request, int $courseId, int $lecturerId)
    {
        $validated = $request->validate([
            'role' => ['required', 'string', 'max:50'],
        ]);
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $course = \Modules\Course\Models\Course::findOrFail($courseId);

        if (!($user->hasRole('admin') || $course->guarantor_id === $user->id)) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->courseLecturerService->updateRole($courseId, $lecturerId, $validated['role']);
            return redirect()->route('course.lecturer.index', $courseId)
                ->with('success', 'Lecturer role updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating lecturer: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified course lecturer
     */
    public function destroy(int $courseId, int $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $course = \Modules\Course\Models\Course::findOrFail($courseId);

        if (!($user->hasRole('admin') || $course->guarantor_id === $user->id)) {
            abort(403, 'Unauthorized');
        }

        $this->courseLecturerService->removeLecturer($courseId, $id);
        return redirect()->route('course.lecturer.index', $courseId)
            ->with('success', 'Lecturer removed from course successfully!');
    }

    /**
     * Get courses by lecturer
     */
    public function getCoursesByLecturer(Request $request, int $lecturerId)
    {
        $courses = $this->courseLecturerService->getCoursesByLecturer($lecturerId);
        return view('course::course_lecturer.lecturer_courses', compact('courses', 'lecturerId'));
    }
}
