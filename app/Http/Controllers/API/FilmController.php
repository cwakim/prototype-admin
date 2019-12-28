<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;

use App\Http\Controllers\API\BaseController as BaseController;

use App\Film;
use Validator;


class FilmController extends BaseController

{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Film::all();

        return $this->sendResponse(
            $products->toArray(),
            'Films retrieved successfully.'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Film::find($id);

        if (is_null($product))
        {
            return $this->sendError('Film not found.');
        }

        return $this->sendResponse(
            $product->toArray(),
            'Product retrieved successfully.'
        );
    }
}
