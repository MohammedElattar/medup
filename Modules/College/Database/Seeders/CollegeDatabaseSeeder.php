<?php

namespace Modules\College\Database\Seeders;

use Illuminate\Database\Seeder;

use Modules\College\Models\College;

class CollegeDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faculties = [
            [
                'name' => ['en' => 'Faculty Of Medicine', 'ar' => 'كلية الطب'],
                'description' => ['en' => 'Dive into clinical practices and patient care essentials to prepare for real-world challenges in healthcare.', 'ar' => 'انغمس في الممارسات السريرية وأساسيات رعاية المرضى للتحضير لتحديات العالم الحقيقي في الرعاية الصحية.']
            ],
            [
                'name' => ['en' => 'Faculty Of Nursing', 'ar' => 'كلية التمريض'],
                'description' => ['en' => 'Enhance your nursing skills with courses on patient care and clinical practices for a rewarding career in nursing.', 'ar' => 'عزز مهاراتك في التمريض من خلال دورات في رعاية المرضى والممارسات السريرية لمهنة مجزية في التمريض.']
            ],
            [
                'name' => ['en' => 'Faculty Of Science', 'ar' => 'كلية العلوم'],
                'description' => ['en' => 'Strengthen your foundation in biology, chemistry, and physiology to support your medical career.', 'ar' => 'عزز أساسك في علم الأحياء والكيمياء وعلم وظائف الأعضاء لدعم حياتك المهنية الطبية.']
            ],
            [
                'name' => ['en' => 'Faculty Of Dentistry', 'ar' => 'كلية طب الأسنان'],
                'description' => ['en' => 'Dentistry has the power to transform lives. By creating stunning smiles, we boost confidence and contribute to overall well-being.', 'ar' => 'طب الأسنان لديه القدرة على تغيير الحياة. من خلال إنشاء ابتسامات رائعة، نعزز الثقة ونساهم في الرفاهية العامة.']
            ],
            [
                'name' => ['en' => 'Faculty Of Veterinary', 'ar' => 'كلية الطب البيطري'],
                'description' => ['en' => 'Help protect animal health and the environment. Be part of the solution to global health challenges.', 'ar' => 'ساعد في حماية صحة الحيوانات والبيئة. كن جزءًا من الحل لتحديات الصحة العالمية.']
            ],
            [
                'name' => ['en' => 'Faculty Of Pharmacy', 'ar' => 'كلية الصيدلة'],
                'description' => ['en' => 'Learn about pharmacology, drug interactions, and patient counseling to excel in medication management.', 'ar' => 'تعلم عن علم الأدوية وتفاعلات الأدوية وإرشاد المرضى للتفوق في إدارة الأدوية.']
            ],
            [
                'name' => ['en' => 'Faculty Of Laboratory', 'ar' => 'كلية المختبر'],
                'description' => ['en' => 'The Medical Laboratory Department tests body fluids to diagnose diseases and monitor treatments.', 'ar' => 'يقوم قسم المختبر الطبي باختبار سوائل الجسم لتشخيص الأمراض ومراقبة العلاجات.']
            ],
            [
                'name' => ['en' => 'Faculty Of Physical Therapy', 'ar' => 'كلية العلاج الطبيعي'],
                'description' => ['en' => 'Start your journey to help patients and rehabilitate them.', 'ar' => 'ابدأ رحلتك لمساعدة المرضى وإعادة تأهيلهم.']
            ],
            [
                'name' => ['en' => 'Faculty Of Radiology', 'ar' => 'كلية الأشعة'],
                'description' => ['en' => 'Become a medical imaging expert and diagnose with precision.', 'ar' => 'كن خبيرًا في التصوير الطبي وشخص بدقة.']
            ]
        ];

        foreach ($faculties as $faculty) {
            College::query()->createQuietly([
                'name' => $faculty['name'],
                'description' => $faculty['description'],
            ]);
        }
    }
}
