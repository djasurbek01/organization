<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $buildings = Building::all();
        $activities = Activity::all();

        $org1 = Organization::create([
            'name' => 'ООО "Рога и Копыта"',
            'phones' => json_encode(['2-222-222', '3-333-333']),
            'building_id' => $buildings->random()->id,
        ]);
        $org1->activities()->attach($activities->where('name', 'Мясная продукция')->pluck('id'));

        $org2 = Organization::create([
            'name' => 'ЗАО "Сырный Дом"',
            'phones' => json_encode(['4-444-444']),
            'building_id' => $buildings->random()->id,
        ]);
        $org2->activities()->attach($activities->where('name', 'Молочная продукция')->pluck('id'));
    }
}
