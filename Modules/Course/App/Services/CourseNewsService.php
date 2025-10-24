<?php

namespace Modules\Course\App\Services;

use Modules\Course\Models\CourseNews;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseNewsService
{
    /**
     * Get all news for a specific course
     */
    public function getByCourse(int $courseId): Collection
    {
        return CourseNews::with(['author', 'course'])
            ->where('course_id', $courseId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get paginated news for a course
     */
    public function getPaginatedByCourse(int $courseId, int $perPage = 15): LengthAwarePaginator
    {
        return CourseNews::with(['author', 'course'])
            ->where('course_id', $courseId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get news by ID
     */
    public function getById(int $id): CourseNews
    {
        return CourseNews::with(['author', 'course'])->findOrFail($id);
    }

    /**
     * Create news for a course
     */
    public function create(int $courseId, int $authorId, array $data): CourseNews
    {
        return DB::transaction(function () use ($courseId, $authorId, $data) {
            return CourseNews::create([
                'course_id' => $courseId,
                'author_id' => $authorId,
                'title' => $data['title'],
                'description' => $data['description'],
            ]);
        });
    }

    /**
     * Update news
     */
    public function update(int $id, array $data): CourseNews
    {
        return DB::transaction(function () use ($id, $data) {
            $courseNews = CourseNews::findOrFail($id);
            $courseNews->update($data);
            return $courseNews->fresh(['author', 'course']);
        });
    }

    /**
     * Delete news
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $courseNews = CourseNews::findOrFail($id);
            return $courseNews->delete();
        });
    }

    /**
     * Get news by author
     */
    public function getByAuthor(int $authorId): Collection
    {
        return CourseNews::with(['author', 'course'])
            ->where('author_id', $authorId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Search news by title or description
     */
    public function search(int $courseId, string $query): Collection
    {
        return CourseNews::with(['author', 'course'])
            ->where('course_id', $courseId)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

}