<?php

namespace Database\Seeders;

use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleTableSeeder::class);

        $role = Role::where('name', '=', 'Super Admin')->first();
        $role->permissions()->sync(Permission::get()->pluck('id'));

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'username' => 'superadmin',
            'password' => bcrypt(123456),
            'email_verified_at' => Carbon::now(),
            'role_id' => Role::where('name', '=', 'Super Admin')->first()->id,
            'status' => 'active',
            'is_admin' => 1,

        ]);
        
        $this->call(CountrySeeder::class);
    }
}
