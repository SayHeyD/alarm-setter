<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTempEntryRequest;
use App\Http\Requests\SetTempLimitsRequest;
use App\Settings\GeneralSettings;
use Illuminate\Http\RedirectResponse;
use App\Models\Temperature;
use App\Models\Device;

class TemperatureController extends Controller
{
    public function setLimits(SetTempLimitsRequest $request, GeneralSettings $settings): RedirectResponse
    {
        $settings->topLimit = $request->topLimit;
        $settings->bottomLimit = $request->bottomLimit;
        $settings->save();

        return redirect()->back()->with('success', 'Die Limits wurden gesetzt und werden in den nächsten 10 Sekunden aktualisiert');
    }

    public function create(CreateTempEntryRequest $request, GeneralSettings $settings)
    {
        $device = Device::where('device_id', $request->device);

        $returnCode = 0;

        if ($device == null)
        {
            $device = new Device();
            $device->device_id = $request->device;
        }

        $device->recorded = $request->recorded;
        $device->recorded_at = $request->recorded_at;

        $device->save();

        if ($device->recorded >= $settings->topLimit)
        {
            $returnCode = 1;
        }
        elseif ($device->recorded <= $settings->bottomLimit)
        {
            $returnCode = 2;
        }

        return response()->json([
            'code' => $returnCode,
        ]);
    }
}
