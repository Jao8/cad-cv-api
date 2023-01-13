<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * CVs Statuses Seeder.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'name' => 'Aprovado',
                'slug' => 'approved'
            ],
            [
                'name' => 'Reprovado',
                'slug' => 'unapproved'
            ]
        ];

        DB::table('statuses')->insert($statuses);
    }
}
