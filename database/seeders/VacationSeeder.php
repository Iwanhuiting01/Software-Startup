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
        // Temporarily disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear the vacations table
        Vacation::truncate();

        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Seed the vacations table with updated fields
        Vacation::create([
            'title' => 'Zonvakantie naar Spanje',
            'description' => 'Geniet van de zon en de zee in Spanje.',
            'long_description' => 'Deze vakantie biedt u de kans om te ontspannen aan de Spaanse kust met prachtige stranden, lokale gastronomie en cultuur.',
            'max_group_size' => 15,
            'min_group_size' => 5,
            'current_participants' => 4,
            'price' => 499.99,
            'start_date' => '2025-06-01',
            'end_date' => '2025-06-15',
            'image' => '/images/Spanje-vaca.webp',
            'user_id' => 1, // Ensure this user exists in the users table
        ]);

        Vacation::create([
            'title' => 'Skiën in Oostenrijk',
            'description' => 'Prachtige pistes en après-ski plezier.',
            'long_description' => 'Deze skivakantie is ideaal voor sneeuwliefhebbers. Geniet van uitdagende pistes en gezellige avonden in Oostenrijk.',
            'max_group_size' => 20,
            'min_group_size' => 8,
            'current_participants' => 6,
            'price' => 799.50,
            'start_date' => '2025-01-10',
            'end_date' => '2025-01-20',
            'image' => '/images/Oostenrijk-skie.jpg',
            'user_id' => 1,
        ]);

        Vacation::create([
            'title' => 'Cultuurreis naar Rome',
            'description' => 'Bezoek het Colosseum en de Vaticaanstad.',
            'long_description' => 'Ontdek de rijke geschiedenis van Rome met een bezoek aan historische bezienswaardigheden en heerlijke Italiaanse gerechten.',
            'max_group_size' => 12,
            'min_group_size' => 4,
            'current_participants' => 5,
            'price' => 399.00,
            'start_date' => '2025-04-01',
            'end_date' => '2025-04-07',
            'image' => '/images/Rome-cultuur.jpg',
            'user_id' => 1,
        ]);

        Vacation::create([
            'title' => 'Rondreis door Thailand',
            'description' => 'Ontdek de schoonheid van Thailand, van tempels tot stranden.',
            'long_description' => 'Een unieke kans om de cultuur, tempels en tropische stranden van Thailand te verkennen in een onvergetelijke rondreis.',
            'max_group_size' => 10,
            'min_group_size' => 3,
            'current_participants' => 3,
            'price' => 1199.99,
            'start_date' => '2025-10-01',
            'end_date' => '2025-10-20',
            'image' => '/images/thailand-rondreis.jpg',
            'user_id' => 1,
        ]);

        Vacation::create([
            'title' => 'Safari in Zuid-Afrika',
            'description' => 'Ga op avontuur in de wildernis en spot de Big Five.',
            'long_description' => 'Maak een onvergetelijke safari door de Zuid-Afrikaanse savanne en ontdek de Big Five in hun natuurlijke habitat.',
            'max_group_size' => 8,
            'min_group_size' => 4,
            'current_participants' => 4,
            'price' => 1599.00,
            'start_date' => '2025-07-01',
            'end_date' => '2025-07-15',
            'image' => '/images/Zuid-afrika-safari.jpg',
            'user_id' => 1,
        ]);

        Vacation::create([
            'title' => 'Wandeltrektocht in de Alpen',
            'description' => 'Geniet van de rust en het uitzicht tijdens een trektocht.',
            'long_description' => 'Verken de Alpen tijdens een wandelavontuur, geniet van prachtige landschappen en de frisse berglucht.',
            'max_group_size' => 15,
            'min_group_size' => 6,
            'current_participants' => 7,
            'price' => 699.99,
            'start_date' => '2025-09-01',
            'end_date' => '2025-09-10',
            'image' => '/images/Alpen-wandelen.jpg',
            'user_id' => 1,
        ]);

        Vacation::create([
            'title' => 'Eilandhoppen in Griekenland',
            'description' => 'Ontdek de Griekse eilanden met hun witte huizen en blauwe zeeën.',
            'long_description' => 'Beleef de unieke sfeer van de Griekse eilanden, inclusief witgekalkte huizen, kristalhelder water en traditionele dorpen.',
            'max_group_size' => 10,
            'min_group_size' => 5,
            'current_participants' => 6,
            'price' => 899.99,
            'start_date' => '2025-08-01',
            'end_date' => '2025-08-14',
            'image' => '/images/Griekenland-eilandhoppen.jpg',
            'user_id' => 1,
        ]);

        Vacation::create([
            'title' => 'Citytrip naar Parijs',
            'description' => 'Bezoek de Eiffeltoren en geniet van de Franse keuken.',
            'long_description' => 'Verken Parijs, de stad van de liefde, en ontdek bezienswaardigheden zoals de Eiffeltoren, het Louvre en de Notre-Dame.',
            'max_group_size' => 25,
            'min_group_size' => 10,
            'current_participants' => 10,
            'price' => 299.00,
            'start_date' => '2025-05-01',
            'end_date' => '2025-05-05',
            'image' => '/images/Parijs-stedentrip.jpg',
            'user_id' => 1,
        ]);
    }
}
