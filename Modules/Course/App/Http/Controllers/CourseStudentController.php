<?php

namespace Modules\Course\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Course\App\Services\CourseStudentService;
use Modules\User\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Modules\Course\Models\Course;

class CourseStudentController extends Controller
{
    private $courseStudentService;

    public function __construct(CourseStudentService $courseStudentService)
    {
        $this->courseStudentService = $courseStudentService;
    }

    public function index(Request $request, int $courseId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $course = Course::findOrFail($courseId);
        $isLecturerForCourse = $course->lecturers()->where('lecturer_id', $user->id)->exists();

        if (!($user->hasAnyRole(['admin', 'guarantor']) || $isLecturerForCourse)) {
            abort(403, 'Unauthorized');
        }

        $courseStudents = $this->courseStudentService->getByCourse($courseId);
        return view('course::course_student.index', compact('courseStudents', 'courseId', 'course'));
    }

    public function create(int $courseId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $course = Course::findOrFail($courseId);
        $isLecturerForCourse = $course->lecturers()->where('lecturer_id', $user->id)->exists();

        if (!($user->hasAnyRole(['admin', 'guarantor']))) {
            abort(403, 'Unauthorized');
        }

        $users = User::select('id', 'first_name', 'last_name')
            ->orderBy('created_at', 'desc')
            ->get()->mapWithKeys(fn($user) => [$user->id => "{$user->first_name} {$user->last_name}"])
            ->toArray();
        return view('course::course_student.create', compact('courseId', 'users'));
    }

    public function store(Request $request, int $courseId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $course = Course::findOrFail($courseId);
        $isLecturerForCourse = $course->lecturers()->where('lecturer_id', $user->id)->exists();

        if (!($user->hasAnyRole(['admin', 'guarantor']))) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'student_id' => ['required', 'exists:users,id'],
            'final_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'is_approved' => ['nullable', 'in:0,1'],
        ]);

        try {
            $courseStudent = $this->courseStudentService->addStudent(
                $courseId,
                $validated['student_id'],
                $validated
            );

            return redirect()->route('course.student.index', $courseId)
                ->with('success', 'Student enrolled in course successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show(int $courseId, int $studentId)
    {
        $courseStudent = $this->courseStudentService->getById($courseId, $studentId);
        return view('course::course_student.show', compact('courseStudent', 'courseId', 'studentId'));
    }

    public function edit(int $courseId, int $studentId)
    {
        $course = Course::findOrFail($courseId);
        $this->authorize('course-student.update', $course);
        
        $courseStudent = $this->courseStudentService->getById($courseId, $studentId);
        return view('course::course_student.edit', compact('courseStudent', 'courseId', 'studentId'));
    }

    public function update(Request $request, int $courseId, int $studentId)
    {
        Log::info('CourseStudentController.update called', [
            'course_id' => $courseId,
            'student_id' => $studentId,
            'input' => $request->all(),
            'ip' => $request->ip(),
        ]);

        $validated = $request->validate([
            'final_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'is_approved' => ['nullable', 'in:0,1'],
        ]);

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $course = Course::findOrFail($courseId);
        
        // Authorize using policy
        $this->authorize('course-student.update', $course);

        // Lecturers can only update grades, not approval status
        if ($user->hasRole('lecturer') && !$user->hasAnyRole(['admin', 'guarantor'])) {
            unset($validated['is_approved']);
        }

        try {
            $this->courseStudentService->update($courseId, $studentId, $validated);
            Log::info('CourseStudentController.update success', [
                'course_id' => $courseId,
                'student_id' => $studentId,
                'validated' => $validated,
            ]);

            return redirect()->route('course.student.index', $courseId)
                ->with('success', 'Student enrollment updated successfully!');
        } catch (\Exception $e) {
            Log::error('CourseStudentController.update failed', [
                'course_id' => $courseId,
                'student_id' => $studentId,
                'validated' => isset($validated) ? $validated : null,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(int $courseId, int $studentId)
    {
        $this->courseStudentService->removeStudent($courseId, $studentId);

        return redirect()->route('course.student.index', $courseId)
            ->with('success', 'Student removed from course successfully!');
    }

    public function getCoursesByStudent(Request $request, int $studentId)
    {
        $courses = $this->courseStudentService->getCoursesByStudent($studentId);
        return view('course::course_student.student_course', compact('courses', 'studentId'));
    }

    public function approved(int $courseId)
    {
        $courseStudents = $this->courseStudentService->getApprovedByCourse($courseId);
        return view('course::course_student.approved', compact('courseStudents', 'courseId'));
    }

    public function pending(int $courseId)
    {
        $courseStudents = $this->courseStudentService->getPendingByCourse($courseId);
        return view('course::course_student.pending', compact('courseStudents', 'courseId'));
    }

    public function approve(int $courseId, int $studentId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        if (!$user->hasAnyRole(['admin', 'guarantor'])) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->courseStudentService->update($courseId, $studentId, [
                'is_approved' => 1,
                'approved_at' => now()
            ]);
            return redirect()->route('course.student.index', $courseId)
                ->with('success', 'Student enrollment approved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(int $courseId, int $studentId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        if (!$user->hasAnyRole(['admin', 'guarantor'])) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->courseStudentService->update($courseId, $studentId, [
                'is_approved' => 0,
                'approved_at' => null
            ]);
            return redirect()->route('course.student.index', $courseId)
                ->with('success', 'Student enrollment rejected successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateScore(Request $request, int $courseId, int $studentId)
    {
        $validated = $request->validate([
            'final_score' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $course = Course::findOrFail($courseId);
        $isLecturerForCourse = $course->lecturers()->where('lecturer_id', $user->id)->exists();

        if (!($user->hasAnyRole(['admin', 'guarantor']) || $isLecturerForCourse)) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->courseStudentService->updateScoreByCourseAndStudent($courseId, $studentId, $validated['final_score']);
            return redirect()->route('course.student.index', $courseId)
                ->with('success', 'Student score updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function lookupPublic(int $courseId, Request $request)
    {
        $id = $request->query('id');
        if (!$id || !is_numeric($id)) {
            return response('', 200);
        }

        $user = User::find((int) $id);
        if (!$user) {
            return response('', 200);
        }

        $name = $user->name ?? trim((($user->first_name ?? '') . ' ' . ($user->last_name ?? '')));

        return response($name ?: '', 200);
    }

    public function scores(int $courseId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $course = Course::findOrFail($courseId);
        $isLecturerForCourse = $course->lecturers()->where('lecturer_id', $user->id)->exists();

        if (!($user->hasAnyRole(['admin', 'guarantor']) || $isLecturerForCourse)) {
            abort(403, 'Unauthorized');
        }

        $courseStudents = $this->courseStudentService->getStudentsWithScores($courseId);
        return view('course::course_student.scores', compact('courseStudents', 'courseId'));
    }

    public function bulkApprove(Request $request, int $courseId)
    {
        $validated = $request->validate([
            'student_ids' => ['required', 'array'],
            'student_ids.*' => ['integer', 'exists:course_student,id'],
        ]);

        try {
            $count = $this->courseStudentService->bulkApprove($validated['student_ids']);
            return redirect()->route('course.student.index', $courseId)
                ->with('success', "Successfully approved {$count} students!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function bulkReject(Request $request, int $courseId)
    {
        $validated = $request->validate([
            'student_ids' => ['required', 'array'],
            'student_ids.*' => ['integer', 'exists:course_student,id'],
        ]);

        try {
            $count = $this->courseStudentService->bulkReject($validated['student_ids']);
            return redirect()->route('course.student.index', $courseId)
                ->with('success', "Successfully rejected {$count} students!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function registerCurrentUser(Request $request, int $courseId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'confirm' => ['accepted'],
        ]);

        $user = auth()->user();

        try {
            $course = Course::findOrFail($courseId);

            try {
                $courseStudent = $this->courseStudentService->addStudent($courseId, $user->id, []);

                if ($courseStudent->is_approved) {
                    $enrolledMessage = 'You have been registered and automatically approved for this course.';
                } else {
                    if ($course->isFull()) {
                        $enrolledMessage = "Course is full (capacity: {$course->capacity}). You have been registered and are pending approval. The guarantor will review your registration.";
                    } else {
                        $enrolledMessage = 'You have been registered for this course (pending approval).';
                    }
                }
            } catch (\Exception $e) {
                if (stripos($e->getMessage(), 'already enrolled') !== false) {
                    $enrolledMessage = 'You are already registered for this course.';
                } else {
                    throw $e;
                }
            }

            $highest = $user->getHighestRole();
            $higherRoles = ['admin', 'guarantor', 'lecturer'];

            if (!in_array($highest, $higherRoles, true) && !$user->hasRole('student')) {
                $user->assignRole('student');
            }

            return redirect()->back()->with('success', $enrolledMessage ?? 'Registered successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function unregisterCurrentUser(Request $request, int $courseId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        try {
            $removed = $this->courseStudentService->removeStudent($courseId, $user->id);

            if ($removed) {
                return redirect()->back()->with('success', 'You have been unregistered from the course.');
            }

            return redirect()->back()->with('info', 'You were not registered for this course.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function registerMultiple(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'course_ids' => ['required', 'array'],
            'course_ids.*' => ['integer', 'exists:courses,id'],
            'confirm' => ['nullable'],
        ]);

        $user = auth()->user();
        $messages = [];

        foreach ($validated['course_ids'] as $courseId) {
            $course = Course::find($courseId);
            $courseName = $course ? $course->name : "Course #{$courseId}";
            try {
                $this->courseStudentService->addStudent($courseId, $user->id, []);
                $messages[] = "Registered for course '{$courseName}'";
            } catch (\Exception $e) {
                $messages[] = "{$courseName}: " . $e->getMessage();
            }
        }

        $highest = $user->getHighestRole();
        $higherRoles = ['admin', 'guarantor', 'lecturer'];
        if (!in_array($highest, $higherRoles, true) && !$user->hasRole('student')) {
            $user->assignRole('student');
        }

        return redirect()->back()->with('success', implode('; ', array_slice($messages, 0, 5)));
    }

    public function unregisterMultiple(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'course_ids' => ['required', 'array'],
            'course_ids.*' => ['integer', 'exists:courses,id'],
        ]);

        $user = auth()->user();
        $messages = [];

        foreach ($validated['course_ids'] as $courseId) {
            $course = Course::find($courseId);
            $courseName = $course ? $course->name : "Course #{$courseId}";
            try {
                $removed = $this->courseStudentService->removeStudent($courseId, $user->id);
                $messages[] = $removed ? "Unregistered from course '{$courseName}'" : "Not registered for course '{$courseName}'";
            } catch (\Exception $e) {
                $messages[] = "{$courseName}: " . $e->getMessage();
            }
        }

        return redirect()->back()->with('success', implode('; ', array_slice($messages, 0, 5)));
    }

    /**
     * Update registrations in bulk: accepts visible_course_ids[] and selected_course_ids[] (selected means register)
     */
    public function updateRegistrations(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'visible_course_ids' => ['required', 'array'],
            'visible_course_ids.*' => ['integer', 'exists:courses,id'],
            'selected_course_ids' => ['nullable', 'array'],
            'selected_course_ids.*' => ['integer', 'exists:courses,id'],
        ]);

        $user = auth()->user();
        $visible = array_map('intval', $validated['visible_course_ids']);
        $selected = isset($validated['selected_course_ids']) ? array_map('intval', $validated['selected_course_ids']) : [];

        // Diagnostic logging to help debug why registrations may not be applied
        Log::info('updateRegistrations: incoming', [
            'user_id' => $user->id,
            'visible' => $visible,
            'selected' => $selected,
            'raw_request' => $request->all(),
        ]);

        $currentEnrollments = $this->courseStudentService->getCoursesByStudent($user->id)->pluck('course_id')->map(fn($v) => (int) $v)->toArray();

        $toRegister = array_values(array_diff($selected, $currentEnrollments));
        $visibleCurrent = array_values(array_intersect($currentEnrollments, $visible));
        $toUnregister = array_values(array_diff($visibleCurrent, $selected));

        Log::info('updateRegistrations: computed diffs', [
            'current_enrollments' => $currentEnrollments,
            'to_register' => $toRegister,
            'to_unregister' => $toUnregister,
        ]);

        $messages = [];

        foreach ($toRegister as $courseId) {
            // Resolve course name for messaging
            $course = Course::find($courseId);
            $courseName = $course ? $course->name : "Course {$courseId}";

            try {
                // Allow registration even if full - it will go to pending status
                $courseStudent = $this->courseStudentService->addStudent($courseId, $user->id, []);

                if ($courseStudent->is_approved) {
                    $messages[] = "Registered and approved for course {$courseName}";
                } else {
                    if ($course && method_exists($course, 'isFull') && $course->isFull()) {
                        $messages[] = "Course {$courseName} is full. Registered (pending guarantor approval)";
                    } else {
                        $messages[] = "Registered for course {$courseName} (pending approval)";
                    }
                }
            } catch (\Exception $e) {
                $messages[] = "{$courseName}: " . $e->getMessage();
            }
        }

        foreach ($toUnregister as $courseId) {
            $course = Course::find($courseId);
            $courseName = $course ? $course->name : "Course #{$courseId}";

            try {
                $removed = $this->courseStudentService->removeStudent($courseId, $user->id);
                $messages[] = $removed ? "Unregistered from course {$courseName}" : "Not registered for course {$courseName}";
            } catch (\Exception $e) {
                $messages[] = "Course {$courseName}: " . $e->getMessage();
            }
        }

        if (!empty($toRegister)) {
            $highest = $user->getHighestRole();
            $higherRoles = ['admin', 'guarantor', 'lecturer'];
            if (!in_array($highest, $higherRoles, true) && !$user->hasRole('student')) {
                $user->assignRole('student');
            }
        }

        return redirect()->back()->with('success', implode('; ', array_slice($messages, 0, 12)));
    }
}
