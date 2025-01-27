<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class TranslationHelper
{
    public static string $defaultLocale = 'en';

    public static array $availableLocales = [
        'en',
        'ar',
    ];

    public static function generateFakeTranslatedInput(string $functionName = 'name', ...$params): array
    {
        $translatedName = [];
        foreach (static::$availableLocales as $locale) {
            $fakeName = fake($locale)->{$functionName}(...$params);
            $translatedName[$locale] = $fakeName;
        }

        return $translatedName;
    }

    public static function generateFakeTranslatedNameAndSlug(array &$translatedName, array &$translatedSlug): void
    {
        foreach (static::$availableLocales as $locale) {
            $fakeName = fake($locale)->name();
            $translatedName[$locale] = $fakeName;
            $translatedSlug[$locale] = Str::slug($fakeName);
        }
    }

    public static function getTranslatedValue($model, string $fieldName)
    {
        $shouldTranslate = $model->shouldTranslate();

        if (! $shouldTranslate) {
            return $model->{$fieldName};
        }

        $translatedValue = $model->getTranslations($fieldName);
        $result = [];

        foreach (self::getAvailableLocales() as $locale) {
            $result[$locale] = $translatedValue[$locale] ?? '';
        }

        return $result;
    }

    public static function getAvailableLocales(): array
    {
        return static::$availableLocales;
    }

    public static function localesFlags()
    {
        return [
            'en' => 'us',
            'ar' => 'sa',
        ];
    }

    public static function getDefaultLocale()
    {
        return static::$defaultLocale;
    }

    public static function getCurrentLocale()
    {
        return session()->get('locale', auth()->user()?->locale ?: 'en');
    }

    public static function translateWord(string $word)
    {
        return translate_ui(Str::replace(' ', '_', Str::lower($word)));
    }

    public static function isRtl()
    {
        return self::getCurrentLocale() == 'ar';
    }

    public static function mergeDefaultTranslatedInput(string $keyName = 'name'): void
    {
        $acceptedLocales = self::getAvailableLocales();
        $firstValue = null;

        foreach ($acceptedLocales as $locale) {
            if (! $firstValue) {
                $firstValue = request()->input("$keyName.$locale");
            }
        }

        $input = request()->input($keyName);

        foreach ($acceptedLocales as $locale) {
            if (! isset($input[$locale])) {
                $input[$locale] = $firstValue;
            }
        }

        request()->merge([$keyName => $input]);
    }
}
