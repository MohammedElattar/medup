<?php

namespace Modules\Speciality\Database\Seeders;

use App\Helpers\TranslationHelper;
use Illuminate\Database\Seeder;
use Modules\College\Models\College;
use Modules\Speciality\Models\Speciality;

class SpecialityDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $specializations = [
            ['en' => 'General Surgery', 'ar' => 'جراحة عامة', 'college_id' => 1],
            ['en' => 'Pediatrics', 'ar' => 'طب الأطفال', 'college_id' => 1],
            ['en' => 'Emergency Medicine', 'ar' => 'طب الطوارئ', 'college_id' => 1],
            ['en' => 'Obstetrics and Gynecology', 'ar' => 'طب النساء والتوليد', 'college_id' => 1],
            ['en' => 'Ophthalmology', 'ar' => 'طب العيون', 'college_id' => 1],
            ['en' => 'Neurology', 'ar' => 'طب الأعصاب', 'college_id' => 1],
            ['en' => 'Otolaryngology (ENT)', 'ar' => 'أنف وأذن وحنجرة', 'college_id' => 1],
            ['en' => 'Orthopedics', 'ar' => 'جراحة العظام', 'college_id' => 1],
            ['en' => 'Dermatology', 'ar' => 'طب الجلدية', 'college_id' => 1],
            ['en' => 'Orthodontics', 'ar' => 'تقويم الأسنان', 'college_id' => 2],
            ['en' => 'Oral Surgery', 'ar' => 'جراحة الفم', 'college_id' => 2],
            ['en' => 'Endodontics', 'ar' => 'علاج الجذور', 'college_id' => 2],
            ['en' => 'Clinical Pharmacy', 'ar' => 'الصيدلة الإكلينيكية', 'college_id' => 5],
            ['en' => 'Pharmaceutical Chemistry', 'ar' => 'الكيمياء الصيدلانية', 'college_id' => 5],
            ['en' => 'Biology', 'ar' => 'علم الأحياء', 'college_id' => 6],
            ['en' => 'Chemistry', 'ar' => 'الكيمياء', 'college_id' => 6],
            ['en' => 'Physics', 'ar' => 'الفيزياء', 'college_id' => 6],
            ['en' => 'Medical Microbiology', 'ar' => 'الأحياء الدقيقة الطبية', 'college_id' => 7],
            ['en' => 'Clinical Biochemistry', 'ar' => 'الكيمياء الحيوية الإكلينيكية', 'college_id' => 7],
            ['en' => 'Musculoskeletal Therapy', 'ar' => 'علاج العضلات والعظام', 'college_id' => 8],
            ['en' => 'Neurological Rehabilitation', 'ar' => 'إعادة التأهيل العصبي', 'college_id' => 8],
            ['en' => 'Diagnostic Radiology', 'ar' => 'الأشعة التشخيصية', 'college_id' => 9],
            ['en' => 'Radiation Therapy', 'ar' => 'العلاج الإشعاعي', 'college_id' => 9],
        ];

        foreach($specializations as $specialization) {
            $i = $specialization;
            unset($i['college_id']);

            Speciality::query()->create([
                'name' => $i,
                'college_id' => $specialization['college_id'],
            ]);
        }
    }
}
