<?php

namespace Modules\Term\Policies;
//
//   @file  TermStudentPolicy.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief  Policy class for TermStudent model authorization
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Term\Models\Term;
use Modules\Term\Models\TermStudent;
use Modules\User\Models\User;

class TermStudentPolicy {
    use HandlesAuthorization;
    /**
     * View any term students
     *
     * @param User $user
     * @param Term $term
     * @return void
     */
    public function viewAny(User $user, Term $term) {
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        if ($user->hasRole('lecturer') && $term->lecturer_id === $user->id) {
            return true;
        }
        return false;
    }
    /**
     * View a specific term student
     *
     * @param User $user
     * @param TermStudent $student
     * @return void
     */
    public function view(User $user, TermStudent $student) {
        $term = $student->term;
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        if ($user->hasRole('lecturer') && $term->lecturer_id === $user->id) {
            return true;
        }
        return false;
    }
    /**
     * Add a student to the term
     *
     * @param User $user
     * @param Term $term
     * @return void
     */
    public function create(User $user, Term $term) {
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        return false;
    }
    /**
     * Update a term student
     *
     * @param User $user
     * @param TermStudent $student
     * @return void
     */
    public function update(User $user, TermStudent $student) {
        $term = $student->term;
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        if ($user->hasRole('lecturer') && $term->lecturer_id === $user->id) {
            return true;
        }
        return false;
    }
    /**
     * Remove a student from the term
     *
     * @param User $user
     * @param TermStudent $student
     * @return void
     */
    public function delete(User $user, TermStudent $student) {
        $term = $student->term;
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        return false;
    }
}
