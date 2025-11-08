<?php

namespace Modules\Course\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Course\App\Services\CourseStudentService;
use Modules\User\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class CourseStudentController extends Controller {
    private $courseStudentService;

    public function __construct(CourseStudentService $courseStudentService) {
        $this->courseStudentService = $courseStudentService;
    }

    public function index(Request $request, int $courseId) {
        $courseStudents = $this->courseStudentService->getByCourse($courseId);
        return view('course::course_student.index', compact('courseStudents', 'courseId'));
    }

    public function create(int $courseId): View {
        $users = User::select('id', 'first_name', 'last_name')
            ->orderBy('created_at', 'desc')
            ->get()->mapWithKeys(fn($user) => [$user->id => "{$user->first_name} {$user->last_name}"])
            ->toArray();
        return view('course::course_student.create', compact('courseId', 'users'));
    }

    public function store(Request $request, int $courseId) {
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

    public function show(int $courseId, int $studentId) {
        $courseStudent = $this->courseStudentService->getById($courseId, $studentId);
        return view('course::course_student.show', compact('courseStudent', 'courseId', 'studentId'));
    }

    public function edit(int $courseId, int $studentId) {
        $courseStudent = $this->courseStudentService->getById($courseId, $studentId);
        return view('course::course_student.edit', compact('courseStudent', 'courseId', 'studentId'));
    }

    public function update(Request $request, int $courseId, int $studentId) {
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

    public function destroy(int $courseId, int $studentId) {
        // Remove student by course and student id
        $this->courseStudentService->removeStudent($courseId, $studentId);

        return redirect()->route('course.student.index', $courseId)
            ->with('success', 'Student removed from course successfully!');
    }

    public function getCoursesByStudent(Request $request, int $studentId) {
        $courses = $this->courseStudentService->getCoursesByStudent($studentId);
        return view('course::course_student.student_course', compact('courses', 'studentId'));
    }

    public function approved(int $courseId) {
        $courseStudents = $this->courseStudentService->getApprovedByCourse($courseId);
        return view('course::course_student.approved', compact('courseStudents', 'courseId'));
    }

    public function pending(int $courseId) {
        $courseStudents = $this->courseStudentService->getPendingByCourse($courseId);
        return view('course::course_student.pending', compact('courseStudents', 'courseId'));
    }

    public function approve(int $courseId, int $studentId) {
        try {
            $this->courseStudentService->update($courseId, $studentId, [
                'is_approved' => 1,
                'approved_at' => now()
            ]);
            return redirect()->route('course.student.index', $courseId)
                ->with('success', 'Student enrollment approved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    public function reject(int $courseId, int $studentId) {
        try {
            $this->courseStudentService->update($courseId, $studentId, [
                'is_approved' => 0,
                'approved_at' => null
            ]);
            return redirect()->route('course.student.index', $courseId)
                ->with('success', 'Student enrollment rejected successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    public function updateScore(Request $request, int $courseId, int $studentId) {
        $validated = $request->validate([
            'final_score' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        try {
            $this->courseStudentService->updateScoreByCourseAndStudent($courseId, $studentId, $validated['final_score']);
            return redirect()->route('course.student.index', $courseId)
                ->with('success', 'Student score updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Public lookup that returns plain text name (no JSON, no auth required).
     * Useful for non-API pages where JS just needs a user name for an ID.
     */
    public function lookupPublic(int $courseId, Request $request) {
        $id = $request->query('id');
        if (!$id || !is_numeric($id)) {
            return response('', 200);
        }

        $user = User::find((int) $id);
        if (!$user) {
            return response('', 200);
        }

        // Prefer a `name` property if present, otherwise build from first/last name
        $name = $user->name ?? trim((($user->first_name ?? '') . ' ' . ($user->last_name ?? '')));

        return response($name ?: '', 200);
    }

    public function scores(int $courseId) {
        $courseStudents = $this->courseStudentService->getStudentsWithScores($courseId);
        return view('course::course_student.scores', compact('courseStudents', 'courseId'));
    }

    /**
     * Bulk approve students
     */
    public function bulkApprove(Request $request, int $courseId) {
        $validated = $request->validate([
            'student_ids' => ['required', 'array'],
            'student_ids.*' => ['integer', 'exists:course_student,id'],
        ]);

        try {
            $count = $this->courseStudentService->bulkApprove($validated['student_ids']);
            return redirect()->route('course.student.index', $courseId)
                ->with('success', "Successfully approved {$count} students!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Bulk reject students
     */
    public function bulkReject(Request $request, int $courseId) {
        $validated = $request->validate([
            'student_ids' => ['required', 'array'],
            'student_ids.*' => ['integer', 'exists:course_student,id'],
        ]);

        try {
            $count = $this->courseStudentService->bulkReject($validated['student_ids']);
            return redirect()->route('course.student.index', $courseId)
                ->with('success', "Successfully rejected {$count} students!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}
