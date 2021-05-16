<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostProfession;

class PostProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostProfession::factory(15)->create();
    }
}
