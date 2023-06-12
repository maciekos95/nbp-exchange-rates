<?php

namespace App\Controllers;

use App\Services\Lang;
use App\Services\View;

class HomeController
{
    /**
     * Display the home page.
     */
    public function displayHomePage(): void
    {
        View::render('home', 'Home page');
    }

    /**
     * Display the 404 Not Found page.
     */
    public function display404NotFoundPage(): void
    {
        View::render(null, Lang::get('page_not_found_title'), [
            'errorMessages' => [Lang::get('page_not_found_message_1') . '<br>' . Lang::get('page_not_found_message_2')],
        ]);
    }

    /**
     * Set the language cookie based on the GET request query parameter.
     */
    public function setLanguageCookie(): void
    {
        if (isset($_GET['language'])) {
            setcookie('language', $_GET['language'], time() + 86400 * 30, '/');
        }
    }
}
