<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Role;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear tables
        DB::table('admins')->delete();
        DB::table('roles')->delete();

        //Create Admin and Super Admin

        /** @var Admin $superAdmin */
        $superAdmin = Admin::create(
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@yearbook.com',
                'password' => 'admin'
            ]);
        $superAdmin->roles()->create(
            [
                'key' => 'super-admin',
                'value' => 'Super Admin'
            ]);

        Role::create([
            'key' => 'admin',
            'value' => 'admin'
        ]);
    }
}
