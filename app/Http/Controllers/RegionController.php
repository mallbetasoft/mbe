<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Countrie;
class RegionController extends Controller
{
    //
	public function stateList(){
		$list = State::join('countries','states.country_id','=','countries.id')->get(['states.*','countries.name']);
		return view('region/state',['details' => $list]);
	}
	
	public function countryList(){
		$list = Countrie::all();
		return view('region/countries',['details' => $list]);
	}
}
