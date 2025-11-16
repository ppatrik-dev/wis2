<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\User\database\seeders\UserDatabaseSeeder;
use Modules\Course\database\seeders\CourseDatabaseSeeder;
use Modules\Course\database\seeders\CourseStudentDatabaseSeeder;
use Modules\Term\database\seeders\TermDatabaseSeeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $this->call([
            UserDatabaseSeeder::class,
            CourseDatabaseSeeder::class,
            CourseStudentDatabaseSeeder::class,
            TermDatabaseSeeder::class
        ]);
    }
}
