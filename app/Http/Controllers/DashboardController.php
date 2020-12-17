<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function view(): Response
    {
        return Inertia::render('Dashboard', [
            'CurrentTemp' => null,
        ]);
    }
}