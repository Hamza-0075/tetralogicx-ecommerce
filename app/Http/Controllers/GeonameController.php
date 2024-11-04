<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;
class GeonameController extends Controller
{
    public function getCountries()
    {
        $countries = DB::table('countries')->get();

        return response()->json($countries);
    }


    public function getStates($countryId)
    {
        // $country = DB::table('countries')->where('name', $countryName)->first();
        $states = DB::table('states')->where('country_id', $countryId)->get();
        // dd($states);
        return response()->json($states);
    }

    public function getCities($stateId)
    {
        // $state = DB::table('states')->where('name', $stateName)->first();
        $cities = DB::table('cities')->where('state_id', $stateId)->get();
        return response()->json($cities);
    }

}
