<?php

namespace Modules\College\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\College\Models\College;

class CollegeDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faculties = [
            ["en" => "Faculty of Medicine", "ar" => "كلية الطب"],
            ["en" => "Faculty of Dentistry", "ar" => "كلية طب الأسنان"],
            ["en" => "Faculty of Veterinary", "ar" => "كلية الطب البيطري"],
            ["en" => "Faculty of Nursing", "ar" => "كلية التمريض"],
            ["en" => "Faculty of Pharmacy", "ar" => "كلية الصيدلة"],
            ["en" => "Faculty of Science", "ar" => "كلية العلوم"],
            ["en" => "Faculty of Laboratory", "ar" => "كلية المختبرات الطبية"],
            ['en' => 'Faculty Of Physical Therapy', 'ar' => 'كلية العلاج الطبيعي'],
            ['en' => 'Faculty Of Radiology', 'ar' => 'كلية الأشعة']
        ];

        foreach ($faculties as $faculty) {
            College::query()->create([
                'name' => $faculty,
            ]);
        }
    }
}
