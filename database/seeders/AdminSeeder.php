<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the admin user account.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@medicalapp.com'],
            [
                'name'                    => 'System Admin',
                'email'                   => 'admin@medicalapp.com',
                'password'                => Hash::make('admin@123'),
                'phone'                   => '9800000000',
                'blood_group'             => 'O+',
                'emergency_contact_name'  => 'Emergency Admin',
                'emergency_contact_phone' => '9800000001',
                'relation'                => 'Admin',
                'role'                    => 'admin',
            ]
        );

        $this->command->info('Admin user created: admin@medicalapp.com / admin@123');
    }
}
