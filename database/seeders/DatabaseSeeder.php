<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Database\Seeders\PasienSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
      public function run(): void
    {
        $faker = Faker::create('id_ID');
        $usedKtp = [];
        $usedPhone = [];

        for ($i = 0; $i < 100; $i++) {
            // Pastikan no_ktp dan phone_number unik
            do {
                $no_ktp = $faker->unique()->nik();
            } while (in_array($no_ktp, $usedKtp));
            $usedKtp[] = $no_ktp;

            do {
                $phone = $faker->unique()->phoneNumber();
            } while (in_array($phone, $usedPhone));
            $usedPhone[] = $phone;

            $tanggal_lahir = $faker->date('Y-m-d', '-18 years');
            $age = \Carbon\Carbon::parse($tanggal_lahir)->age;

            DB::table('pasiens')->insert([
                'name'           => $faker->name,
                'no_ktp'         => $no_ktp,
                'tanggal_lahir'  => $tanggal_lahir,
                'age'            => $age,
                'address'        => $faker->address,
                'phone_number'   => $phone,
                'keluhan'        => $faker->sentence,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
