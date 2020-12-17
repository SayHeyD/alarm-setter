<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetTempLimitsRequest;
use App\Settings\GeneralSettings;
use Illuminate\Http\RedirectResponse;

class TemperatureController extends Controller
{
    public function setLimits(SetTempLimitsRequest $request, GeneralSettings $settings): RedirectResponse
    {
        $settings->topLimit = $request->topLimit;
        $settings->bottomLimit = $request->bottomLimit;
        $settings->save();

        return redirect()->back()->with('success', 'Die Limits wurden gesetzt und werden in den nächsten 10 Sekunden aktualisiert');
    }

    public function create()
    {

    }
}
