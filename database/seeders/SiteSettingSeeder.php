<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'site_title' => 'Dashboard Management System',
                'site_subtitle' => 'Your Total Solution Wealth Management',
                'site_tagline' => 'Empowering future leaders',

                'site_description' => 'আমাদের বিদ্যালয় মানসম্মত শিক্ষা, নৈতিকতা ও সৃজনশীলতা বিকাশে প্রতিশ্রুতিবদ্ধ। অভিজ্ঞ শিক্ষকমণ্ডলী ও আধুনিক শিক্ষাব্যবস্থার মাধ্যমে শিক্ষার্থীদের আদর্শ মানুষ হিসেবে গড়ে তোলাই আমাদের লক্ষ্য।',
                'favicon_path' => 'assets/images/favicon.ico',
                'light_logo_path' => 'assets/images/logo-light.png',
                'dark_logo_path' => 'assets/images/logo-dark.png',
                'phone' => '01911607750',
                'email' => 'i2uinedu@gmail.com',
                'address' => '123 Education Avenue, Dhaka, Bangladesh',

                'website' => 'https://school.edu.bd',
                'updated_by' => null,
            ]
        );

        $this->command->info('Site Setting created successfully.');
    }
}
