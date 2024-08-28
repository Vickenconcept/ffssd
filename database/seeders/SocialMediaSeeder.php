<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SocialMedia::create(['name' => 'Facebook', 'url' => 'https://facebook.com/company']);
        SocialMedia::create(['name' => 'Twitter', 'url' => 'https://twitter.com/company']);
        SocialMedia::create(['name' => 'LinkedIn', 'url' => 'https://linkedin.com/company']);
    }
}
