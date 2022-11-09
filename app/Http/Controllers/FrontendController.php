<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;

class FrontendController extends Controller
{
    public function index()
    {
        $flights = Flight::all();
        return view('front.pages.customers-db', compact('flights'));
    }
}
