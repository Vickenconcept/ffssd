<?php

namespace Database\Seeders;

use App\Models\NavigationItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavigationItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NavigationItem::create(['name' => 'Home', 'url' => '/']);
        NavigationItem::create(['name' => 'About Us', 'url' => '/about']);
        NavigationItem::create(['name' => 'FAQ', 'url' => '/faq']);
        NavigationItem::create(['name' => 'Contact', 'url' => '/contact']);
    }
}
