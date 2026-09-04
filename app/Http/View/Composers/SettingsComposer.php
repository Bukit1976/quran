<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Auth;

class SettingsComposer
{
    public function compose(View $view)
    {
        if (Auth::check()) {
            $settings = UserSetting::getOrCreate(Auth::id());
            $view->with('userSettings', $settings);
        }
    }
}
