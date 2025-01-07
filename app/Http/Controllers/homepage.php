<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homepage extends Controller
{
    //

    public function Homepage()
    {
        // Redirect to a named route
        return view('homepage');
    }
}
