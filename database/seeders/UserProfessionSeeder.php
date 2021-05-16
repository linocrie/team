<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserProfession;

class UserProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserProfession::factory(15)->create();
    }
}
