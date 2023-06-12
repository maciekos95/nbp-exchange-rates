<?php use App\Services\Lang; ?>

<h2><?= Lang::get('conversion_form_title') ?></h2>

<form method="POST">
    <div class="form-row">
        <label for="amount"><?= Lang::get('conversion_form_label_amount') ?>:</label>
        <input type="number" name="amount" class="input-field" data-message="<?= Lang::get('conversion_form_amount_validation') ?>" required oninput="validateAmount(this)">
    </div>

    <div class="form-row">
        <label for="source_currency"><?= Lang::get('conversion_form_label_source') ?>:</label>
        <select name="source_currency" class="select-field" required>
            <?php foreach ($currencies as $currency): ?>
                <option value="<?= $currency ?>"><?= $currency ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-row">
        <label for="target_currency"><?= Lang::get('conversion_form_label_target') ?>:</label>
        <select name="target_currency" class="select-field" required>
            <?php foreach ($currencies as $currency): ?>
                <option value="<?= $currency ?>"><?= $currency ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="submit-button" data-message="<?= Lang::get('conversion_form_currency_validation') ?>"><?= Lang::get('conversion_form_submit') ?></button>
</form>

<script src="resources/js/form.js"></script>
