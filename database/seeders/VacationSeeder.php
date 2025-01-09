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

        // Leeg de tabel voordat je nieuwe vakanties toevoegt
        Vacation::truncate();


        Vacation::create([
            'title' => 'Zonvakantie naar Spanje',
            'description' => 'Geniet van de zon en de zee in Spanje.',
            'group_size' => 15,
            'current_participants' => 4,
            'image' => '/images/Spanje-vaca.webp'
        ]);

        Vacation::create([
            'title' => 'Skiën in Oostenrijk',
            'description' => 'Prachtige pistes en après-ski plezier.',
            'group_size' => 20,
            'current_participants' => 6,
            'image' => '/images/Oostenrijk-skie.jpg'
        ]);

        Vacation::create([
            'title' => 'Cultuurreis naar Rome',
            'description' => 'Bezoek het Colosseum en de Vaticaanstad.',
            'group_size' => 12,
            'current_participants' => 5,
            'image' => '/images/Rome-cultuur.jpg'
        ]);

        Vacation::create([
            'title' => 'Rondreis door Thailand',
            'description' => 'Ontdek de schoonheid van Thailand, van tempels tot stranden.',
            'group_size' => 10,
            'current_participants' => 3,
            'image' => '/images/thailand-rondreis.jpg'
        ]);

        Vacation::create([
            'title' => 'Safari in Zuid-Afrika',
            'description' => 'Ga op avontuur in de wildernis en spot de Big Five.',
            'group_size' => 8,
            'current_participants' => 4,
            'image' => '/images/Zuid-afrika-safari.jpg'
        ]);

        Vacation::create([
            'title' => 'Wandeltrektocht in de Alpen',
            'description' => 'Geniet van de rust en het uitzicht tijdens een trektocht.',
            'group_size' => 15,
            'current_participants' => 7,
            'image' => '/images/Alpen-wandelen.jpg'
        ]);

        Vacation::create([
            'title' => 'Eilandhoppen in Griekenland',
            'description' => 'Ontdek de Griekse eilanden met hun witte huizen en blauwe zeeën.',
            'group_size' => 10,
            'current_participants' => 6,
            'image' => '/images/Griekenland-eilandhoppen.jpg'
        ]);

        Vacation::create([
            'title' => 'Citytrip naar Parijs',
            'description' => 'Bezoek de Eiffeltoren en geniet van de Franse keuken.',
            'group_size' => 25,
            'current_participants' => 10,
            'image' => '/images/Parijs-stedentrip.jpg'
        ]);

    }
}
