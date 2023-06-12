<?php

require_once 'autoload.php';

use App\Controllers\HomeController;
use App\Controllers\ExchangeRatesController;
use App\Controllers\ConversionController;

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);

switch ($path) {
    case '/':
        $controller = new HomeController;
        if ($requestMethod == 'GET') {
            $controller->displayHomePage();
        }
        break;
    case '/exchange-rates':
        $controller = new ExchangeRatesController;
        if ($requestMethod == 'GET') {
            $controller->displayExchangeRates();
        }
        break;
    case '/conversion':
        $controller = new ConversionController;
        if ($requestMethod == 'GET') {
            $controller->displayConversionForm();
        }
        elseif ($requestMethod == 'POST') {
            $controller->processConversionForm();
        }
        break;
    case '/conversion-results':
        $controller = new ConversionController;
        if ($requestMethod == 'GET') {
            $controller->displayLatestConversionResults();
        }
        break;
    case '/set-language':
        $controller = new HomeController;
        if ($requestMethod == 'GET') {
            $controller->setLanguageCookie();
        }
        break;
    default:
        $controller = new HomeController;
        $controller->display404NotFoundPage();
        break;
}
