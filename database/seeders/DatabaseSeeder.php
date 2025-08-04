<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Absensi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@absensi.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@absensi.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'user@absensi.com'],
            [
                'name' => 'Karyawan',
                'email' => 'user@absensi.com',
                'password' => Hash::make('user123'),
                'email_verified_at' => now(),
            ]
        );

        $this->createSampleAbsensi($admin->id);
    }

    private function createSampleAbsensi($userId)
    {
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now('Asia/Jakarta')->subDays($i)->startOfDay();
            
            if ($tanggal->isWeekend() && $i > 2) {
                continue;
            }

            $jamMasuk = $this->getRandomWorkStartTime();
            $jamKeluar = null;
            
            if (rand(1, 10) <= 8 && $i > 0) { 
                $jamKeluar = $this->getRandomWorkEndTime($jamMasuk);
            }

            Absensi::firstOrCreate(
                [
                    'user_id' => $userId,
                    'tanggal' => $tanggal->format('Y-m-d')
                ],
                [
                    'jam_masuk' => $jamMasuk,
                    'jam_keluar' => $jamKeluar,
                    'status' => 'Hadir'
                ]
            );
        }
    }

    private function getRandomWorkStartTime()
    {
        $hour = rand(7, 8);
        $minute = rand(0, 59);
        
        if ($hour == 8 && $minute > 30) {
            $minute = rand(0, 30); 
        }
        
        return sprintf('%02d:%02d:%02d', $hour, $minute, rand(0, 59));
    }

    private function getRandomWorkEndTime($jamMasuk)
    {
        $masuk = Carbon::createFromFormat('H:i:s', $jamMasuk);
        
        $workHours = rand(8, 9);
        $keluar = $masuk->copy()->addHours($workHours)->addMinutes(rand(0, 30));
        
        return $keluar->format('H:i:s');
    }
}
