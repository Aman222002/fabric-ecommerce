<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                'id' => 1,
                'partner_name' => 'Mencap',
                'partner_logo' => '1-1.webp',
            ],
            [
                'id' => 2,
                'partner_name' => 'NonStop',
                'partner_logo' => '1-2.webp',
            ],
            [
                'id' => 3,
                'partner_name' => 'Herbal',
                'partner_logo' => '1-3.webp',
            ],
            [
                'id' => 4,
                'partner_name' => 'MichaelPage',
                'partner_logo' => '1-4.webp',
            ],
            [
                'id' => 5,
                'partner_name' => 'PagePersonal',
                'partner_logo' => '1-5.webp',
            ],
            [
                'id' => 6,
                'partner_name' => 'Lorem-Ipsum',
                'partner_logo' => '1-6.jpg',
            ],
        ];

        DB::table('partners')->upsert(
            $partners,
            ['id'],
            ['partner_name', 'partner_logo', 'created_at', 'updated_at']
        );
    }
}
