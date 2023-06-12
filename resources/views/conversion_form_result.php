<?php use App\Services\Lang; ?>

<h2><?= Lang::get('conversion_form_result_title') ?></h2>

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
        <tr>
            <td><?php echo $conversionResult->sourceCurrency; ?></td>
            <td><?php echo $conversionResult->targetCurrency; ?></td>
            <td><?php echo number_format($conversionResult->amount, 2); ?></td>
            <td><?php echo number_format($conversionResult->convertedAmount, 2); ?></td>
        </tr>
    </tbody>
</table>
