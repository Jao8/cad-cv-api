<?php

namespace Database\Seeders;

use App\Enum\Types;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Administrador',
                'password' => bcrypt('adm123'),
                'email' => 'adm@evtek.com',
                'email_verified_at' => Carbon::now(),
                'type_id' => Types::ADMIN
            ],
            [
                'name' => 'Gestor',
                'password' => bcrypt('gestor123'),
                'email' => 'gestao@evtek.com',
                'email_verified_at' => Carbon::now(),
                'type_id' => Types::MANAGER
            ],
        ];
        DB::table('users')->insert($users);
    }
}
