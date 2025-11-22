<?php
/**
 * @file TermStudentController.php
 * @author Patrik Procházka (xprochp00@vutbr.cz)
 * @brief Controller for managing terms students in the Term module
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

namespace Modules\Term\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Term\Models\TermStudent;
use Modules\Term\Models\Term;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TermStudentController extends Controller {
    /**
     * Display a listing of the students.
     *
     * @param Term $term
     * @return void
     */
    public function index(Term $term) {
        $students = $term->termStudents();
        $this->authorize('viewAny', $term);
        return view('term::term_student.index', ["term" => $term, "students" => $students]);
    }

    /**
     * Show the form for creating a new student.
     *
     * @param Term $term
     * @return void
     */
    public function create(Term $term) {
        $this->authorize('create', $term);
        return view('term::term_student.create', ["term" => $term]);
    }

    /**
     * Store a newly created student in storage.
     *
     * @param Request $request
     * @param Term $term
     * @return void
     */
    public function store(Request $request, Term $term) {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'score' => 'nullable|numeric|min:0|max:100',
        ]);

        $courseStudents = $term->course_students;

        if (!array_key_exists($validated['student_id'], $courseStudents)) {
            return redirect()
                ->back()
                ->withErrors(['student_id' => 'Selected student does not belong to this term course.'])
                ->withInput();
        }

        $termStudent = TermStudent::create(
            [
                'term_id' => $term->id,
                'student_id' => $validated['student_id'],
            ],
            [
                'score' => $validated['score'] ?? null,
            ]
        );

        return redirect()
            ->route('term.student.index', $term)
            ->with('success', 'Student added to the term successfully!');
    }

    /**
     * Display the specified student.
     *
     * @param Term $term
     * @param [type] $studentId
     * @return void
     */
    public function show(Term $term, $studentId) {
        $student = $term->termStudentBy($studentId);
        // $this->authorize('view', $student);
        return view('term::term_student.show', ["term" => $term, "student" => $student]);
    }

    /**
     * Show the form for editing the specified student.
     *
     * @param Term $term
     * @param [type] $studentId
     * @return void
     */
    public function edit(Term $term, $studentId) {
        $student = $term->termStudentBy($studentId);
        // $this->authorize('update', $student);
        return view('term::term_student.edit', ["term" => $term, "student" => $student]);
    }

    /**
     * Update the specified student in storage.
     *
     * @param Request $request
     * @param Term $term
     * @param [type] $studentId
     * @return void
     */
    public function update(Request $request, Term $term, $studentId) {
        $validated = $request->validate([
            'score' => 'nullable|numeric|min:0|max:100',
        ]);

        $termStudent = $term->termStudents()
            ->where('student_id', $studentId)->first();
        $this->authorize('update', $termStudent);
        if (!$termStudent) {
            return redirect()
                ->back()
                ->withErrors(['student_id' => 'Selected student does not belong to this term.'])
                ->withInput();
        }

        $termStudent->update([
            'score' => $validated['score'],
        ]);

        return redirect()->route('term.student.index', $term->id)
            ->with('success', 'Student term score updated successfully!');
    }

    /**
     * Remove the specified student from storage.
     *
     * @param Term $term
     * @param [type] $studentId
     * @return void
     */
    public function destroy(Term $term, $studentId) {
        $termStudent = $term->termStudents()
            ->where('student_id', $studentId)->first();
        $this->authorize('delete', $termStudent);
        if (!$termStudent) {
            return redirect()
                ->back()
                ->withErrors(['student_id' => 'Selected student does not belong to this term.'])
                ->withInput();
        }

        $termStudent->delete();

        return redirect()->route('term.student.index', $term->id)
            ->with('success', 'Student removed from term successfully!');
    }

    /**
     * Register the specified student to storage.
     *
     * @param Term $term
     * @return void
     */
    public function register(Term $term) {
        $user = Auth::user();

        $termStudent = TermStudent::create(
            [
                'term_id' => $term->id,
                'student_id' => $user->id,
            ],
            [
                'score' => null,
            ]
        );

        return redirect()->route('term.index')
            ->with('success', 'Logged user registered to the term successfully!');
    }

    /**
     * Unregister the specified student from storage.
     *
     * @param Term $term
     * @return void
     */
    public function unregister(Term $term) {
        $user = Auth::user();

        $termStudent = TermStudent::where([
            'term_id' => $term->id, 'student_id' => $user->id
        ])->firstOrFail();

        $termStudent->delete();

        return redirect()->route('term.index')
            ->with('success', 'Logged user unregistered from the term successfully!');
    }
}
