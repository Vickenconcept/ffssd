<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::create([
            'background_image' => 'background1.jpg',
            'title' => 'Welcome to Our Company',
            'content' => 'We offer the best services.',
            'cta_text' => 'Learn More',
            'cta_url' => '/about',
            'is_active' => true,
        ]);

        Section::create([
            'background_image' => 'background2.jpg',
            'title' => 'Our Services',
            'content' => 'We provide various solutions.',
            'cta_text' => 'See Services',
            'cta_url' => '/services',
            'is_active' => true,
        ]);
    }
}
