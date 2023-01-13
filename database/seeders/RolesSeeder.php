<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Job Open Roles Seeder.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Desenvolvedor',
                'slug' => 'developer'
            ],
            [
                'name' => 'RH',
                'slug' => 'hr'
            ],
            [
                'name' => 'Recepcionista',
                'slug' => 'receptionist'
            ]
        ];

        DB::table('roles')->insert($roles);
    }
}
