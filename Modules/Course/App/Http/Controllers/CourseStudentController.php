<?php

namespace Modules\Course\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Course\App\Services\CourseStudentService;
use Modules\User\Models\User;
use Illuminate\View\View;

class CourseStudentController extends Controller
{
    private $courseStudentService;

    public function __construct(CourseStudentService $courseStudentService)
    {
        $this->courseStudentService = $courseStudentService;
    }

    public function index(Request $request, int $courseId)
    {
        $courseStudents = $this->courseStudentService->getByCourse($courseId);
        return view('course::course_student.index', compact('courseStudents', 'courseId'));
    }

    public function create(int $courseId): View
    {
        return view('course::course_student.create', compact('courseId'));
    }

    public function store(Request $request, int $courseId)
    {
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
        $courseStudent = $this->courseStudentService->getById($courseId, $studentId);
        return view('course::course_student.edit', compact('courseStudent', 'courseId', 'studentId'));
    }

    public function update(Request $request, int $courseId, int $studentId)
    {
        $validated = $request->validate([
            'final_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'is_approved' => ['nullable', 'in:0,1'],
        ]);

        try {
            $this->courseStudentService->update($courseId, $studentId, $validated);
            return redirect()->route('course.student.index', $courseId)
                ->with('success', 'Student enrollment updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(int $courseId, int $id)
    {
        $this->courseStudentService->delete($id);

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

    public function reject(int $courseId, int $studentId)
    {
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

    public function updateScore(Request $request, int $courseId, int $id)
    {
        $validated = $request->validate([
            'final_score' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        try {
            $this->courseStudentService->updateScore($id, $validated['final_score']);
            return redirect()->route('course.student.index', $courseId)
                ->with('success', 'Student score updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    public function scores(int $courseId)
    {
        $courseStudents = $this->courseStudentService->getStudentsWithScores($courseId);
        return view('course::course_student.scores', compact('courseStudents', 'courseId'));
    }

    /**
     * Bulk approve students
     */
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
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Bulk reject students
     */
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
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}