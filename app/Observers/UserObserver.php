<?php

namespace App\Observers;

use App\Models\NotifikasiSholat;
use App\Models\User;
use App\Models\UserSettings;

class UserObserver
{
    public function created(User $users)
    {
        // Create default settings
        UserSettings::createDefault($users->id);

        // Create default notifications
        NotifikasiSholat::createDefaultForPengguna($users->id);
    }
}
