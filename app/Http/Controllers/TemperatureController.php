<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTempEntryRequest;
use App\Http\Requests\SetTempLimitsRequest;
use App\Settings\GeneralSettings;
use Carbon\Carbon;
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
        // Initializing return Code for response
        $returnCode = 0;

        // DEVICE SECTION
        $device = Device::where('device_id', $request->device)->first();

        if ($device == null)
        {
            $device = new Device();
            $device->device_id = $request->device;
        }

        $device->last_update = Carbon::now()->toDateTimeString();
        $device->save();

        if ($request->recorded >= $settings->topLimit)
        {
            $returnCode = 1;
        }
        elseif ($request->recorded <= $settings->bottomLimit)
        {
            $returnCode = 2;
        }

        // TEMPERATURE SAVE
        $temp = new Temperature();

        $temp->recorded = $request->recorded;
        $temp->recorded_at = $request->recorded_at;
        $temp->topLimit = $settings->topLimit;
        $temp->bottomLimit = $settings->bottomLimit;
        $temp->device_id = $device->id;

        $temp->save();

        // Return response code to the board
        return response()->json([
            'code' => $returnCode,
        ]);
    }
}
