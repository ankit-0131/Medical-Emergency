<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Seed sample hospitals into the database.
     */
    public function run(): void
    {
        $hospitals = [
            [
                'name'     => 'City General Hospital',
                'address'  => '12, MG Road, Central District, Delhi - 110001',
                'phone'    => '011-23456789',
                'map_link' => 'https://www.google.com/maps?q=City+General+Hospital+Delhi',
            ],
            [
                'name'     => 'Apollo Medical Center',
                'address'  => '45, Sarita Vihar, South Delhi - 110076',
                'phone'    => '011-26925858',
                'map_link' => 'https://www.google.com/maps?q=Apollo+Hospital+Delhi',
            ],
            [
                'name'     => 'St. Mary Emergency Hospital',
                'address'  => '7, Park Street, Connaught Place, Delhi - 110002',
                'phone'    => '011-23672222',
                'map_link' => 'https://www.google.com/maps?q=St+Mary+Hospital+Delhi',
            ],
            [
                'name'     => 'Sunrise Trauma Centre',
                'address'  => '89, Ring Road, Lajpat Nagar, Delhi - 110024',
                'phone'    => '011-29845678',
                'map_link' => 'https://www.google.com/maps?q=Sunrise+Trauma+Centre+Delhi',
            ],
            [
                'name'     => 'Green Valley Medical Institute',
                'address'  => '23, Mayur Vihar Phase-2, East Delhi - 110091',
                'phone'    => '011-22616677',
                'map_link' => 'https://www.google.com/maps?q=Green+Valley+Hospital+Delhi',
            ],
            [
                'name'     => 'National Emergency Care Centre',
                'address'  => '56, Karol Bagh, North Delhi - 110005',
                'phone'    => '1800-222-111',
                'map_link' => 'https://www.google.com/maps?q=NECC+Delhi',
            ],
        ];

        foreach ($hospitals as $hospital) {
            Hospital::updateOrCreate(
                ['name' => $hospital['name']],
                $hospital
            );
        }

        $this->command->info('6 sample hospitals seeded successfully.');
    }
}
