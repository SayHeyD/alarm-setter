<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetTempLimitsRequest;
use App\Settings\GeneralSettings;
use Illuminate\Http\Request;

class TemperatureController extends Controller
{
    public function setLimits(SetTempLimitsRequest $request, GeneralSettings $settings)
    {
        $settings->topLimit = $request->topLimit;
        $settings->bottomLimit = $request->bottomLimit;
        $settings->save();
    }

    public function create()
    {

    }
}
