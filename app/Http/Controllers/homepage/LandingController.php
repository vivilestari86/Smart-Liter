<?php

namespace App\Http\Controllers\homepage;

use App\Http\Controllers\Controller;
use App\Models\Journal;

class LandingController extends Controller
{
    public function index()
    {

        $journals = Journal::query()
            ->where('status', 'Publish')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('homepage.landing', compact('journals'));
    }
}
