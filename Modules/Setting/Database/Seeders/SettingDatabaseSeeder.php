<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Setting\Models\Setting;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::query()->create([
            'subscription_price' => 200,
            'mail_from' => 'Medup',
            'mail_username' => 'medup@gmail.com',
            'mail_password' => 'medup',
            'mail_host' => 'smtp.gmail.com',
            'mail_port' => '587',
            'mail_encryption' => 'tls',
            'mail_protocol' => 'smtp',
            'stripe_secret_key' => 'sk_test_51I0s2o123alsdfkjalsdkfjalskdfj',
        ]);
    }
}
