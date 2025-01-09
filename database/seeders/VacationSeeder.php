<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vacation;

class VacationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vacation::create([
            'title' => 'Zonvakantie naar Spanje',
            'description' => 'Geniet van de zon en de zee in Spanje.',
            'group_size' => 15,
            'current_participants' => 4,
        ]);

        Vacation::create([
            'title' => 'Skiën in Oostenrijk',
            'description' => 'Prachtige pistes en après-ski plezier.',
            'group_size' => 20,
            'current_participants' => 6,
        ]);

    }
}
