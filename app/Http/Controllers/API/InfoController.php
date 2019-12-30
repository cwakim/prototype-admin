<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;

use App\Http\Controllers\API\BaseController as BaseController;

use App\Film;
use App\People;
use App\Specie;
use App\Vehicle;
use App\Planet;
use Validator;


class InfoController extends BaseController

{

    /**
     * Display a listing of the resource.
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
            if (strlen($maxCrawl['length']) <= $tempLength)
            {
                $maxCrawl['title'] = $film->title;
                $maxCrawl['length'] = $tempLength;
            }
            foreach($film->characters as $character)
            {
                if (!isset($characters[$character]))
                {
                    $characters[$character] = 0;
                }
                $characters[$character] += 1;
            }
            foreach($film->species as $specie)
            {
                if (!isset($species[$specie]))
                {
                    $species[$specie] = 0;
                }
                $species[$specie] += 1;
            }
        }
        uasort($characters, function($a, $b) {
            return $b - $a;
        });

        $mostCharachters = People::where('id', array_key_first($characters))
            ->get()->first()->name;

        uasort($species, function($a, $b) {
            return $b - $a;
        });

        $mostSpecies = Specie::where('id', array_key_first($species))
            ->get()->first()->name;

        $vehicles = Vehicle::where('pilots' , '>' , 0)->get();

        $pilots = [];
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
        uasort($pilots, function($a, $b) {
            return $b - $a;
        });

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
