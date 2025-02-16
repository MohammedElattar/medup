<?php

namespace App\Http\Controllers;

use App\Helpers\TranslationHelper;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function swap($locale)
    {
        if (array_key_exists($locale, TranslationHelper::$availableLocales)) {
            session()->put('locale', $locale);
            App::setLocale($locale);
        }

        echo session()->get('locale');
    }
}
