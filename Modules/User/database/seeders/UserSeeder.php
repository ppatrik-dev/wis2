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

        $student1 = User::firstOrCreate(
            [
                'first_name' => 'Anna',
                'last_name' => 'Kovacova',
                'email' => 'anna.kovacova@student.example',
                'degree' => 'Bc.',
                'gender' => 'female',
                'birth_date' => '1999-02-14',
                'country' => 'Slovakia',
                'bio' => 'Test student Anna',
                'password' => 'studentpass1',
            ]
        );
        $student1->assignRole('student');
        $student1->assignRole('user');

        $student2 = User::firstOrCreate(
            [
                'first_name' => 'Marek',
                'last_name' => 'Novak',
                'email' => 'marek.novak@student.example',
                'degree' => 'Ing.',
                'gender' => 'male',
                'birth_date' => '1997-08-03',
                'country' => 'Slovakia',
                'bio' => 'Test student Marek',
                'password' => 'studentpass2',
            ]
        );
        $student2->assignRole('student');
        $student2->assignRole('user');

        $student3 = User::firstOrCreate(
            [
                'first_name' => 'Lucia',
                'last_name' => 'Horvathova',
                'email' => 'lucia.horvathova@student.example',
                'degree' => 'MSc.',
                'gender' => 'female',
                'birth_date' => '1996-11-22',
                'country' => 'Slovakia',
                'bio' => 'Test student Lucia',
                'password' => 'studentpass3',
            ]
        );
        $student3->assignRole('student');
        $student3->assignRole('user');

        $student4 = User::firstOrCreate(
            [
                'first_name' => 'Peter',
                'last_name' => 'Svec',
                'email' => 'peter.svec@student.example',
                'degree' => 'Bc.',
                'gender' => 'male',
                'birth_date' => '2000-06-30',
                'country' => 'Slovakia',
                'bio' => 'Test student Peter',
                'password' => 'studentpass4',
            ]
        );
        $student4->assignRole('student');
        $student4->assignRole('user');

        $student5 = User::firstOrCreate(
            [
                'first_name' => 'Zuzana',
                'last_name' => 'Mikova',
                'email' => 'zuzana.mikova@student.example',
                'degree' => 'Ing.',
                'gender' => 'female',
                'birth_date' => '1998-04-12',
                'country' => 'Slovakia',
                'bio' => 'Test student Zuzana',
                'password' => 'studentpass5',
            ]
        );
        $student5->assignRole('student');
        $student5->assignRole('user');

        $student6 = User::firstOrCreate(
            [
                'first_name' => 'Tomas',
                'last_name' => 'Varga',
                'email' => 'tomas.varga@student.example',
                'degree' => 'Bc.',
                'gender' => 'male',
                'birth_date' => '1995-12-01',
                'country' => 'Slovakia',
                'bio' => 'Test student Tomas',
                'password' => 'studentpass6',
            ]
        );
        $student6->assignRole('student');
        $student6->assignRole('user');

        $student7 = User::firstOrCreate(
            [
                'first_name' => 'Petra',
                'last_name' => 'Kralova',
                'email' => 'petra.kralova@student.example',
                'degree' => 'Bc.',
                'gender' => 'female',
                'birth_date' => '1999-09-09',
                'country' => 'Slovakia',
                'bio' => 'Test student Petra',
                'password' => 'studentpass7',
            ]
        );
        $student7->assignRole('student');
        $student7->assignRole('user');


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
