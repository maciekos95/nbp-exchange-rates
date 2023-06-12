<?php use App\Services\Lang; ?>

<h2><?= Lang::get('exchange_rates_title') ?></h2>

<table>
    <thead>
        <tr>
            <th><?= Lang::get('exchange_rates_header_code') ?></th>
            <th><?= Lang::get('exchange_rates_header_name') ?></th>
            <th><?= Lang::get('exchange_rates_header_rate') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($exchangeRates as $rate): ?>
            <tr>
                <td><?php echo $rate->currencyCode; ?></td>
                <td><?php echo $rate->currencyName; ?></td>
                <td><?php echo number_format($rate->exchangeRate, 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
