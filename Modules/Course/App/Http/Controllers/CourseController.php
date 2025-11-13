<?php

namespace Modules\Course\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Course\App\Http\Requests\StoreCourseRequest;
use Modules\Course\App\Http\Requests\UpdateCourseRequest;
use Modules\Course\App\Services\CourseService;
use Modules\User\Models\User;
use Modules\Course\Models\Course;
use Illuminate\View\View;


class CourseController extends Controller {

    protected $courseService;
    public function __construct(CourseService $courseService) {
        $this->courseService = $courseService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $query = $request->get('q', '');

        if (!empty($query)) {
            // search helper in CourseService
            $courses = $this->courseService->search($query);
        } else {
            $courses = $this->courseService->getAll();
        }

        return view('course::course.index', compact('courses', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View {
        $this->authorize('create', Course::class);
        // if (!auth()->check() || !auth()->user()->hasAnyRole(['admin', 'guarantor'])) {
        //     abort(403, 'Unauthorized');
        // }

        $users = User::all()->pluck('first_name', 'id')->toArray();
        return view('course::course.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request) {
        $this->authorize('create', Course::class);
        if (!auth()->check() || !auth()->user()->hasAnyRole(['admin', 'guarantor'])) {
            abort(403, 'Unauthorized');
        }

        try {
            $data = $request->validated();

            // If guarantor creates the course, treat it as a suggestion: set guarantor_id to current user and ensure not approved
            if (auth()->user()->hasRole('guarantor') && !auth()->user()->hasRole('admin')) {
                $data['guarantor_id'] = auth()->id();
                $data['is_approved'] = false;
            }

            $course = $this->courseService->create($data);

            // If the course is approved on creation (admin action) and a guarantor is set,
            // promote the guarantor user to 'guarantor' role unless they already have admin/guarantor.
            if ($course->is_approved && $course->guarantor_id) {
                try {
                    $guarantorUser = User::find($course->guarantor_id);
                    if ($guarantorUser) {
                        $highest = $guarantorUser->getHighestRole();
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
        // Only admin can edit courses

        // if (!auth()->check() || !auth()->user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized');
        // }

        $course = $this->courseService->getById((int) $id);
        $this->authorize('update', $course);
        $users = User::all()->pluck('first_name', 'id')->toArray();
        return view('course::course.edit', compact('course', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, $id) {
        // Only admin can update courses
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        try {
            // Load the previous state to detect approval transition
            $oldCourse = $this->courseService->getById((int) $id);

            $course = $this->courseService->update((int) $id, $request->validated());
            $this->authorize('update', $course);
            // If course transitioned from unapproved to approved, promote guarantor to role 'guarantor' (unless already admin/guarantor)
            if (!$oldCourse->is_approved && $course->is_approved && $course->guarantor_id) {
                try {
                    $guarantorUser = User::find($course->guarantor_id);
                    if ($guarantorUser) {
                        $highest = $guarantorUser->getHighestRole();
                        if (!in_array($highest, ['admin', 'guarantor'], true)) {
                            $guarantorUser->syncRoles(['guarantor']);
                        }
                    }
                } catch (\Exception $e) {
                    // Ignore role assignment failure
                }
            }

            // Also ensure that if an admin assigns a guarantor to a course that is already approved,
            // the assigned guarantor receives the 'guarantor' role. This covers the case where
            // the guarantor is set/changed after the course was approved.
            if ($course->is_approved && $course->guarantor_id) {
                try {
                    $guarantorUser = User::find($course->guarantor_id);
                    if ($guarantorUser) {
                        $highest = $guarantorUser->getHighestRole();
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
        $course = Course::findOrFail($id);
        $this->authorize('delete', $course);
        // if (!auth()->check() || !auth()->user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized');
        // }

        $this->courseService->delete((int) $id);
        return redirect()->route('course.index')
            ->with('success', 'Course deleted successfully!');
    }
}
