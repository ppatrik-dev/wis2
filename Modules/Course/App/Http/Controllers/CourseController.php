<?php

namespace Modules\Course\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Course\App\Http\Requests\StoreCourseRequest;
use Modules\Course\App\Http\Requests\UpdateCourseRequest;
use Modules\Course\App\Services\CourseService;
use Modules\User\Models\User;
use Illuminate\View\View;


class CourseController extends Controller
{

    protected $courseService;
    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $user = auth()->user();
        $isAdmin = $user && $user->hasRole('admin');

        if (!empty($query)) {
            // search helper in CourseService
            $courses = $this->courseService->search($query);
            // Filter: non-admin users only see approved courses in search results
            if (!$isAdmin) {
                $courses = $courses->filter(function ($course) {
                    return $course->is_approved;
                });
            }
        } else {
            $courses = $this->courseService->getAll();
            // Filter: non-admin users only see approved courses
            if (!$isAdmin) {
                $courses = $courses->filter(function ($course) {
                    return $course->is_approved;
                });
            }
        }

        return view('course::course.index', compact('courses', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
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
    public function store(StoreCourseRequest $request)
    {
        $this->authorize('course.create');

        try {
            $data = $request->validated();
            $user = auth()->user();

            // Only admin can create approved courses. All others create unapproved courses.
            if (!$user->hasRole('admin')) {
                $data['is_approved'] = false;
                $data['guarantor_id'] = auth()->id();
            }

            $course = $this->courseService->create($data);

            // If the course is approved on creation and a guarantor is set,
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
    public function show($id)
    {
        $course = $this->courseService->getById((int) $id);
        return view('course::course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        // Only admin can edit courses
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $course = $this->courseService->getById((int) $id);
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
    public function update(UpdateCourseRequest $request, $id)
    {
        // Only admin can update courses
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        try {
            // Load the previous state to detect approval transition
            $oldCourse = $this->courseService->getById((int) $id);

            $course = $this->courseService->update((int) $id, $request->validated());

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
                }
            }

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
    public function destroy($id)
    {
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
    public function approve($id)
    {
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

