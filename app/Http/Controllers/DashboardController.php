<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Temperature;

class DashboardController extends Controller
{
    public function view(): Response
    {

        return Inertia::render('Dashboard', [
            'CurrentTemp' => Temperature::latest('created_at')->first()->recorded,
            'topLimit' => Temperature::latest('created_at')->first()->topLimit,
            'bottomLimit' => Temperature::latest('created_at')->first()->bottomLimit,
        ]);
    }
}
