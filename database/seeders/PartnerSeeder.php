<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $partners = [
            [
                'partner_name' => 'Mencap',
                'partner_logo' => '1-1.webp',
            ],
            [
                'partner_name' => 'NonStop',
                'partner_logo' => '1-2.webp',
            ],
            [
                'partner_name' => 'Herbal',
                'partner_logo' => '1-3.webp',
            ],
            [
                'partner_name' => 'MichaelPage',
                'partner_logo' => '1-4.webp',
            ],
            [
                'partner_name' => 'PagePersonal',
                'partner_logo' => '1-5.webp',
            ],
            [
                'partner_name' => 'Lorem-Ipsum',
                'partner_logo' => '1-6.jpg',
            ],
        ];

        // Insert data into database
        foreach ($partners as $partner) {
            DB::table('partners')->insert([
                'partner_name' => $partner['partner_name'],
                'partner_logo' => $partner['partner_logo'],
                // You can add more fields here if needed
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
