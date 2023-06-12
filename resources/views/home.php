<?php use App\Services\Lang; ?>

<div class="welcome-message">
    <h2><?= Lang::get('welcome_message') ?></h2>
    <br>
    <div>
        <?= Lang::get('welcome_text_start') ?>
        <ul>
            <li><?= Lang::get('welcome_text_exchange_rates') ?></li>
            <li><?= Lang::get('welcome_text_convert_currency') ?></li>
            <li><?= Lang::get('welcome_text_conversion_results') ?></li>
        </ul>
    </div>
</div>
