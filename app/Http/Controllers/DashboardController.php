<?php

namespace App\Http\Controllers;

use App\Settings\GeneralSettings;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Temperature;

class DashboardController extends Controller
{
    public function view(GeneralSettings $settings): Response
    {
        $temp = Temperature::latest('created_at')->first();
        $lastEntries = Temperature::latest('created_at')->limit(10)->with('device')->get();

        return Inertia::render('Dashboard', [
            'CurrentTemp' => $temp->recorded ?? null,
            'topLimit' => $temp->topLimit ?? null,
            'bottomLimit' => $temp->bottomLimit ?? null,
            'settingsTopLimit' => $settings->topLimit ?? null,
            'settingsBottomLimit' => $settings->bottomLimit ?? null,
            'lastEntries' => $lastEntries ?? null,
        ]);
    }
}
