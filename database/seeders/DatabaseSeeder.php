<?php

namespace Database\Seeders;

use App\Statuses\HavePermission;
use App\Statuses\UserType;
use Database\Factories\BridePackagesFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            "name" => "Super Admin",
            "email" => "superadmin@gmail.com",
            "password" => bcrypt('0123456789'),
            "type" => UserType::SUPER_ADMIN,
            'permission_to_delay' => HavePermission::FALSE,
            'permission_to_delete' => HavePermission::FALSE,
            'permission_to_update' => HavePermission::FALSE
        ]);
        \App\Models\User::factory()->create([
            "name" => "Admin",
            "email" => "admin@admin.com",
            "password" => bcrypt('0123456789'),
            "type" => UserType::ADMIN,
            'permission_to_delay' => HavePermission::TRUE,
            'permission_to_delete' => HavePermission::TRUE,
            'permission_to_update' => HavePermission::TRUE
        ]);
        \App\Models\User::factory()->create([
            "name" => "Reception",
            "email" => "reception@reception.com",
            "password" => bcrypt('0123456789'),
            "type" => UserType::RECEPTION,
            'permission_to_delay' => HavePermission::FALSE,
            'permission_to_delete' => HavePermission::FALSE,
            'permission_to_update' => HavePermission::FALSE
        ]);
        $this->call(UsersTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(ExpertsTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(BridePackagesTableSeeder::class);
        $this->call(TransfersTableSeeder::class);
        $this->call(ReservationsTableSeeder::class);
    }
}
