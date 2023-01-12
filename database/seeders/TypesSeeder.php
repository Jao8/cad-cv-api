<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['name' => 'Gestor', 'slug' => 'MANAGER'],
            ['name' => 'Administrador', 'slug' => 'ADMIN']
        ];

        DB::table('types')->insert($types);
    }
}
