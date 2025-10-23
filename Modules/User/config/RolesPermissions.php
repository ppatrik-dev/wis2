<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

    'permissions' => [
        'create_course',
        'register_course',
        'view_course',
        'view_all_courses',
        'edit_account',
        'register_terms',
        'view_grade',
        'view_timetable',
        'view_students_in_course',
        'view_students_grade',
        'evaluation_students',
        'manage_course',
        'approve_registration_course',
        'add_lecturer_to_course',
        'delete_lecture_from_course',
        'manage_users',
        'manage_rooms',
        'approve_course'

    ],

    /*
    |--------------------------------------------------------------------------
    | Roles and their permissions
    |--------------------------------------------------------------------------
    */

    'roles' => [
        'user' => [
            'create_course',
            'register_course',
            'view_course',
            'view_all_courses',
            'edit_account',
        ],
        'student' => [
            'register_terms',
            'view_grade',
            'view_timetable'
        ],
        'lecturer' => [
            'view_students_in_course',
            'view_students_grade',
            'evaluation_students'
        ],
        'guarantor' => [
            'manage_course',
            'approve_registration_course',
            'add_lecturer_to_course',
            'delete_lecture_from_course',
        ],
        'admin' => [
            '*'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Hierarchical of the roles
    |--------------------------------------------------------------------------
    */

    'hierarchy' => [
        'admin',
        'guarantor',
        'lecturer',
        'student',
        'user'
    ]


];
