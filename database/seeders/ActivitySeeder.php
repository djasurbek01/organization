<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $food = Activity::create(['name' => 'Еда']);
        Activity::insert([
            ['name' => 'Мясная продукция', 'parent_id' => $food->id],
            ['name' => 'Молочная продукция', 'parent_id' => $food->id],
        ]);

        $cars = Activity::create(['name' => 'Автомобили']);
        Activity::insert([
            ['name' => 'Грузовые', 'parent_id' => $cars->id],
            ['name' => 'Легковые', 'parent_id' => $cars->id],
        ]);
    }
}
