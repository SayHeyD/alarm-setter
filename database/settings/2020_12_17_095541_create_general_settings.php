<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.topLimit', 0);
        $this->migrator->add('general.bottomLimit', 0);
    }
}
