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
    public function create(): View
    {
        $users = User::all()->pluck('first_name', 'id')->toArray();
        return view('course::course.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        try {
            $course = $this->courseService->create($request->validated());
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
        $course = $this->courseService->getById((int) $id);
        $users = User::all()->pluck('first_name', 'id')->toArray();
        return view('course::course.edit', compact('course', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, $id)
    {
        try {
            $course = $this->courseService->update((int) $id, $request->validated());
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
        $this->courseService->delete((int) $id);
        return redirect()->route('course.index')
            ->with('success', 'Course deleted successfully!');
    }
}

