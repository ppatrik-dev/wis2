<?php

namespace Modules\Term\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Course\Models\Course;
use Modules\Term\Models\Term;
use Modules\Term\Models\Room;

class TermStudentSeeder extends Seeder {
    public function run(): void
    {
        $courses = Course::with(['students', 'terms'])->get();
    }
}