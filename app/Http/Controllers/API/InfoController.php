<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Film;
use App\People;
use App\Specie;
use App\Vehicle;
use App\Planet;

class InfoController extends BaseController

{

    /**
     * Returns the needed info to the frontend
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $films = Film::all();

        $maxCrawl = [
            'title' => '',
            'length' => 0,
        ];
        $characters = [];
        $species = [];
        foreach ($films as $film)
        {
            $tempLength = strlen($film->opening_crawl);

            // Check on the length of the crawl and compare it with the crawl saved
            if (strlen($maxCrawl['length']) <= $tempLength)
            {
                $maxCrawl['title'] = $film->title;
                $maxCrawl['length'] = $tempLength;
            }

            // Loops through the characters in the movie and increment their role in the array
            foreach($film->characters as $character)
            {
                if (!isset($characters[$character]))
                {
                    $characters[$character] = 0;
                }
                $characters[$character] += 1;
            }

            // Loops through the species in the movie and increment their count in the array
            foreach($film->species as $specie)
            {
                if (!isset($species[$specie]))
                {
                    $species[$specie] = 0;
                }
                $species[$specie] += 1;
            }
        }

        // Sort the carachters by their number of appearances
        uasort($characters, function($a, $b) {
            return $b - $a;
        });

        // Loads the character with the most appearances
        $mostCharachters = People::where('id', array_key_first($characters))
            ->get()->first()->name;


        // Sort the species by their number of appearances
        uasort($species, function($a, $b) {
            return $b - $a;
        });


        // Loads the species with the most appearances
        $mostSpecies = Specie::where('id', array_key_first($species))
            ->get()->first()->name;

        $vehicles = Vehicle::where('pilots' , '>' , 0)->get();

        $pilots = [];
        // get the pilot of each vehivle that appeared in a movie
        foreach ($vehicles as $vehicle)
        {
            foreach ($vehicle->pilots as $pilot)
            {
                if (!isset($pilots[$pilot]))
                {
                    $pilots[$pilot] = 0;
                }
                $pilots[$pilot] += 1;
            }
        }

        // Sorts the pilot by the number of appearances
        uasort($pilots, function($a, $b) {
            return $b - $a;
        });

        // Load the pilot with thte most vehicles
        $pilot = People::where('id', array_key_first($pilots))
            ->get()->first();

        $planet = Planet::where('id', $pilot->homeworld)->get()->first();

        $info = array (
            'crawl' => $maxCrawl,
            'characters' => array (
                'name' => $mostCharachters,
                'count' => reset($characters),
            ),
            'species' => array (
                'name' => $mostSpecies,
                'count' => reset($species),
            ),
            'planet' => array (
                'name' => $planet->name,
                'pilot' => $pilot->name,
                'count' => reset($pilots),
            )
        );

        return $this->sendResponse(
            $info,
            'Info retrieved successfully.'
        );
    }
}
