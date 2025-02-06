<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Building::insert([
            ['address' => 'Москва, ул. Ленина 1, офис 3', 'latitude' => 55.75, 'longitude' => 37.62],
            ['address' => 'Санкт-Петербург, ул. Большая Морская, 30, лит. А', 'latitude' => 59.94, 'longitude' => 30.31],
            ['address' => 'Новосибирск, ул. Депутатская, д. 46, коворкинг «Практик»', 'latitude' => 55.04, 'longitude' => 82.93],
        ]);
    }
}
