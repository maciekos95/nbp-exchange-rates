<?php

use App\Services\Lang; 

$languages = Lang::list();
$currentLanguage = $_COOKIE['language'] ?? 'en';

if (!isset($errorMessages)) {
    $errorMessages = [];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" href="resources/css/app.css">
    <title><?= $subpageTitle ?> - <?= Lang::get('page_title') ?></title>
</head>
<body>
    <div class="header-container">
        <h1><?= Lang::get('page_title') ?></h1>

        <div class="lang-container">
        <?php foreach ($languages as $language): ?>
            <button class="lang-button" data-lang="<?= $language ?>" <?= ($language == $currentLanguage) ? 'disabled' : '' ?>>
                <?= strtoupper($language) ?>
            </button>
        <?php endforeach ?>
        </div>
    </div>

    <div class="menu-container">
            <a href="/"><?= Lang::get('button_home_page') ?></a>
            <a href="exchange-rates"><?= Lang::get('button_exchange_rates'); ?></a>
            <a href="conversion"><?= Lang::get('button_convert_currency') ?></a>
            <a href="conversion-results"><?= Lang::get('button_conversion_results') ?></a>
    </div>

    <?php if ($errorMessages): ?>
        <div class="error-container">
            <?php foreach ($errorMessages as $message): ?>
                <h2><?= $message ?></h2>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <?php if ($partialFile): ?>
        <div class="content-container">
            <?php include $partialFile . '.php'; ?>
        </div>
    <?php endif ?>

    <script src="resources/js/app.js"></script>
</body>
</html>
