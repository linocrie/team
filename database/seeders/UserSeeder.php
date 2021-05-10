<?php

namespace Database\Seeders;

use App\Models\Detail;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(50)
            ->has(Detail::factory()->count(1))
            ->create();
    }
}
