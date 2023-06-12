<?php

namespace App\Services;

class Lang
{
    /**
     * Get the translation for the specified text in the current language.
     * @param string $text The text to be translated.
     * @return string|null The translated text if available, null otherwise.
     */
    public static function get(string $text): string | null
    {
        $language = $_COOKIE['language'] ?? 'en';
        $langArray = require 'lang/' . $language . '/lang.php';
        return $langArray[$text];
    }

    /**
     * Get the list of available languages.
     * @return array The array of available languages.
     */
    public static function list(): array
    {
        $availableLanguages = array_diff(scandir('lang'), ['.', '..']);

        foreach ($availableLanguages as $language) {
            $languages[] = basename($language);
        }

        return $languages;
    }
}