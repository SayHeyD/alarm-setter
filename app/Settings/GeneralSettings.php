<?php


namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public float $topLimit;
    public float $bottomLimit;

    public static function group(): string
    {
        return 'general';
    }
}