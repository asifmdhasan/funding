<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
            ],
            [
                'name' => 'Employee',
                'slug' => 'employee',
            ],
            [
                'name' => 'Dealer',
                'slug' => 'dealer',
            ],
        ];

        foreach ($data as $info) {
            Role::create($info);
        }
    }
}
