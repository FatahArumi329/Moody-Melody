<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $moods = Mood::all();
        return view('home', compact('moods'));
    }
}


