<?php
/**
 * @file TermStudentDatabaseSeeder.php
 * @author Patrik Procházka (xprochp00@vutbr.cz)
 * @brief Seeder for TermStudent table
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

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