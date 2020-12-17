<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Temperature;

class DashboardController extends Controller
{
    public function view(): Response
    {
        $temp = Temperature::latest('created_at')->first();
        $lastEntries = Temperature::latest('created_at')->limit(10)->get();

        return Inertia::render('Dashboard', [
            'CurrentTemp' => $temp->recorded,
            'topLimit' => $temp->topLimit,
            'bottomLimit' => $temp->bottomLimit,
            'lastEntries' => $lastEntries,
        ]);
    }
}
