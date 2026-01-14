<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $json = File::get(database_path('data/countries.json'));
        // $countries = json_decode($json, true);

        // collect($countries)->each(function ($c) {
        //     DB::table('countries')->insert([
        //         'name_en'    => $c['name_en'],
        //         'name_jp'    => $c['name_jp'],
        //         'code'       => $c['code'] ?? null,
        //         'phone_code' => $c['phone_code'] ?? null,
        //         'currency'   => $c['currency'] ?? null,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // });
    }
}
