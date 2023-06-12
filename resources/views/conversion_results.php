<?php use App\Services\Lang; ?>

<h2><?= Lang::get('conversion_results_title') ?></h2>

<table>
    <thead>
        <tr>
            <th><?= Lang::get('conversion_header_source') ?></th>
            <th><?= Lang::get('conversion_header_target') ?></th>
            <th><?= Lang::get('conversion_header_amount') ?></th>
            <th><?= Lang::get('conversion_header_converted') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($conversionResults as $result): ?>
            <tr>
                <td><?php echo $result->sourceCurrency; ?></td>
                <td><?php echo $result->targetCurrency; ?></td>
                <td><?php echo number_format($result->amount, 2); ?></td>
                <td><?php echo number_format($result->convertedAmount, 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
