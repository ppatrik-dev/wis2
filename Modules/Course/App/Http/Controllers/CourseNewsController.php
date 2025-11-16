<?php

namespace Modules\Course\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Course\App\Services\CourseNewsService;
use Modules\User\Models\User;
use Modules\Course\Models\Course;
use Illuminate\View\View;

class CourseNewsController extends Controller {
    private $courseNewsService;

    public function __construct(CourseNewsService $courseNewsService) {
        $this->courseNewsService = $courseNewsService;
    }

    /**
     * Display a listing of course news for a specific course
     */
    public function index(Request $request, int $courseId) {
        $course = Course::findOrFail($courseId);
        $courseNews = $this->courseNewsService->getByCourse($courseId);
        return view('course::course_news.index', compact('courseNews', 'courseId', 'course'));
    }

    /**
     * Show the form for creating a new course news
     */
    public function create(int $courseId): View {
        return view('course::course_news.create', compact('courseId'));
    }

    /**
     * Store a newly created course news
     */
    public function store(Request $request, int $courseId) {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $authorId = auth()->id();

        $courseNews = $this->courseNewsService->create($courseId, $authorId, $validated);

        return redirect()->route('course.news.index', $courseId)
            ->with('success', 'Course news created successfully!');
    }

    /**
     * Display the specified course news
     */
    public function show(int $courseId, int $id) {
        $courseNews = $this->courseNewsService->getById($id);
        return view('course::course_news.show', compact('courseNews', 'courseId'));
    }

    /**
     * Show the form for editing the specified course news
     */
    public function edit(int $courseId, int $id) {
        $courseNews = $this->courseNewsService->getById($id);
        return view('course::course_news.edit', compact('courseNews', 'courseId'));
    }

    /**
     * Update the specified course news
     */
    public function update(Request $request, int $courseId, int $id) {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $this->courseNewsService->update($id, $validated);

        return redirect()->route('course.news.index', $courseId)
            ->with('success', 'Course news updated successfully!');
    }

    /**
     * Remove the specified course news
     */
    public function destroy(int $courseId, int $id) {
        $this->courseNewsService->delete($id);

        return redirect()->route('course.news.index', $courseId)
            ->with('success', 'Course news deleted successfully!');
    }

    /**
     * Search course news
     */
    public function search(Request $request, int $courseId) {
        $query = $request->get('q', '');
        $courseNews = $this->courseNewsService->search($courseId, $query);

        return view('course::course_news.index', compact('courseNews', 'courseId', 'query'));
    }
}
