<?php

namespace Modules\User\database\seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\User;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $admin = User::firstOrCreate(
            [
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'email' => 'systemadministrator@gmail.com',
                'degree' => 'MSc.',
                'gender' => 'male',
                'birth_date' => '1990-01-01',
                'country' => 'Slovakia',
                'bio' => 'System Administrator Account',
                'password' => 'admin12345',


            ]
        );
        $admin->assignRole('admin');

        $guarantor = User::firstOrCreate(
            [
                'first_name' => 'Default',
                'last_name' => 'Guarantor',
                'email' => 'guarantordefault@gmail.com',
                'degree' => 'Dr.',
                'gender' => 'male',
                'birth_date' => '1990-01-01',
                'country' => 'Slovakia',
                'bio' => 'Default Guarantor Account',
                'password' => 'guarantor12345',
            ]
        );
        $guarantor->assignRole('guarantor');
        $guarantor->assignRole('lecturer');
        $guarantor->assignRole('user');


        $lecturer = User::firstOrCreate(
            [
                'first_name' => 'Default',
                'last_name' => 'Lecturer',
                'email' => 'lecturerdefault@gmail.com',
                'degree' => 'PhD.',
                'gender' => 'female',
                'birth_date' => '1985-03-20',
                'country' => 'Slovakia',
                'bio' => 'Default Lecturer Account',
                'password' => 'lecturer12345',
            ]
        );
        $lecturer->assignRole('lecturer');
        $lecturer->assignRole('user');


        $student = User::firstOrCreate(
            [
                'first_name' => 'Default',
                'last_name' => 'Student',
                'email' => 'defaultstudent@gmail.com',
                'degree' => 'Ing.',
                'gender' => 'female',
                'birth_date' => '1995-05-15',
                'country' => 'Slovakia',
                'bio' => 'Default Student Account',
                'password' => 'student12345',
            ]
        );
        $student->assignRole('student');
        $student->assignRole('user');

        $user = User::firstOrCreate(
            [
                'first_name' => 'Default',
                'last_name' => 'User',
                'email' => 'defaultuser@gmail.com',
                'degree' => 'Bc.',
                'gender' => 'male',
                'birth_date' => '1998-07-10',
                'country' => 'Slovakia',
                'bio' => 'Default User Account',
                'password' => 'user12345',
            ]
        );
        $user->assignRole('user');
    }
}
