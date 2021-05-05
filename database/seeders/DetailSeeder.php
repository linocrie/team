<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Detail;

class DetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Detail::factory(15)->create();
    }
}
