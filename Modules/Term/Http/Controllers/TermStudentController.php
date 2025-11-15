<?php

namespace Modules\Term\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Term\Models\TermStudent;
use Modules\Term\Models\Term;
use Illuminate\Http\Request;

class TermStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Term $term)
    {
        $students = $term->termStudents();
        return view('term::term_student.index', ["term" => $term, "students" => $students]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Term $term)
    {
        return view('term::term_student.create', ["term" => $term]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Term $term)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'score' => 'nullable|numeric|min:0|max:100',
        ]);

        $courseStudents = $term->course_students;

        if (!array_key_exists($validated['student_id'], $courseStudents)) {
            return redirect()
                ->back()
                ->withErrors(['student_id' => 'Selected student does not belong to this term\'s course.'])
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
     * Display the specified resource.
     */
    public function show(Term $term, $studentId)
    {
        $student = $term->termStudentBy($studentId);

        return view('term::term_student.show', ["term" => $term, "student" => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Term $term, $studentId)
    {
        $student = $term->termStudentBy($studentId);

        return view('term::term_student.edit', ["term" => $term, "student" => $student]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Term $term, $studentId)
    {
        $validated = $request->validate([
            'score' => 'nullable|numeric|min:0|max:100',
        ]);

        $termStudent = $term->termStudents()
            ->where('student_id', $studentId)->first();

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
     * Remove the specified resource from storage.
     */
    public function destroy(Term $term, $studentId)
    {
        $termStudent = $term->termStudents()
            ->where('student_id', $studentId)->first();

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
}
