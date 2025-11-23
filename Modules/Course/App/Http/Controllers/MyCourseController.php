<?php

namespace Modules\Course\App\Http\Controllers;

/**
 * @file MyCourseCOntroller.php
 * @author Miroslav Basista (xbasim00), Nataliia Solomatina (xsolom02)
 * @brief Controller for My Courses
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Course\App\Http\Requests\StoreCourseRequest;
use Modules\Course\App\Http\Requests\UpdateCourseRequest;
use Modules\Course\App\Services\CourseService;
use Modules\User\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;



class MyCourseController extends Controller {

    protected $courseService;
    public function __construct(CourseService $courseService) {
        $this->courseService = $courseService;
    }


    /**
     * Show all courses where is user a student
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request) {
        $courses = Auth::user()->courses;
        return view('course::my_course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View {
        $this->authorize('course.create');

        $users = User::select('id', 'first_name', 'last_name')
            ->orderBy('first_name')
            ->get()
            ->mapWithKeys(fn($u) => [$u->id => trim($u->first_name . ' ' . $u->last_name)])
            ->toArray();
        return view('course::course.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request) {
        $this->authorize('course.create');

        try {
            $data = $request->validated();
            $user = auth()->user();

            // Only admin can create approved courses. All others create unapproved courses.
            if (!$user->hasRole('admin')) {
                $data['is_approved'] = false;
                // Non-admin users automatically become the guarantor of the course they create
                $data['guarantor_id'] = auth()->id();
            }

            $course = $this->courseService->create($data);

            // If the course is approved on creation (admin action) and a guarantor is set,
            // promote the guarantor user to 'guarantor' role unless they already have admin/guarantor.
            if ($course->is_approved && $course->guarantor_id) {
                try {
                    $guarantorUser = User::find($course->guarantor_id);
                    if ($guarantorUser) {
                        $highest = $guarantorUser->highest_role;
                        if (!in_array($highest, ['admin', 'guarantor'], true)) {
                            $guarantorUser->syncRoles(['guarantor']);
                        }
                    }
                } catch (\Exception $e) {
                    // Don't block course creation on role assignment failure; log silently if logging available
                }
            }

            return redirect()->route('course.index')->with('success', 'Course created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating course: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id) {
        $course = $this->courseService->getById((int) $id);
        return view('course::course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View {
        $course = $this->courseService->getById((int) $id);
        $this->authorize('course.update', $course);

        $users = User::select('id', 'first_name', 'last_name')
            ->orderBy('first_name')
            ->get()
            ->mapWithKeys(fn($u) => [$u->id => trim($u->first_name . ' ' . $u->last_name)])
            ->toArray();
        return view('course::course.edit', compact('course', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, $id) {
        $oldCourse = $this->courseService->getById((int) $id);
        $this->authorize('course.update', $oldCourse);

        try {
            $data = $request->validated();
            $user = auth()->user();

            // Only admin can change is_approved and guarantor_id
            if (!$user->hasRole('admin')) {
                unset($data['is_approved']);
                unset($data['guarantor_id']);
            }

            $course = $this->courseService->update((int) $id, $data);

            // If course transitioned from unapproved to approved, promote guarantor to role 'guarantor' (unless already admin/guarantor)
            if (!$oldCourse->is_approved && $course->is_approved && $course->guarantor_id) {
                try {
                    $guarantorUser = User::find($course->guarantor_id);
                    if ($guarantorUser) {
                        $highest = $guarantorUser->highest_role;
                        if (!in_array($highest, ['admin', 'guarantor'], true)) {
                            $guarantorUser->syncRoles(['guarantor']);
                        }
                    }
                } catch (\Exception $e) {
                }
            }

            if ($course->is_approved && $course->guarantor_id) {
                try {
                    $guarantorUser = User::find($course->guarantor_id);
                    if ($guarantorUser) {
                        $highest = $guarantorUser->highest_role;
                        if (!in_array($highest, ['admin', 'guarantor'], true)) {
                            $guarantorUser->syncRoles(['guarantor']);
                        }
                    }
                } catch (\Exception $e) {
                    // Ignore role assignment failure
                }
            }

            return redirect()->route('course.show', $course->id)
                ->with('success', 'Course updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating course: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        // Only admin can delete courses
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $this->courseService->delete((int) $id);
        return redirect()->route('course.index')
            ->with('success', 'Course deleted successfully!');
    }

    /**
     * Approve a course (admin only).
     */
    public function approve($id) {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->courseService->approve((int) $id);
            return redirect()->route('course.show', $id)
                ->with('success', 'Course approved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error approving course: ' . $e->getMessage());
        }
    }
}
