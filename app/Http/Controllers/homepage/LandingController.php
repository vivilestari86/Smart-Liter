<?php

namespace App\Http\Controllers\homepage;

use App\Http\Controllers\Controller;
use App\Models\Journal;

class LandingController extends Controller
{
    public function index()
    {
        $journals = Journal::query()
            ->orderBy('created_at', 'asc')
            ->take(3)
            ->get();

        return view('homepage.landing', compact('journals'));
    }
}
