<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use Illuminate\Http\Request;

class homepage extends Controller
{
    //

    public function Homepage()
    {
        $featuredVacations = Vacation::inRandomOrder()->limit(3)->get();

        return view('homepage', compact('featuredVacations'));
    }
}
