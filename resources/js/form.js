function validateAmount(input) {
    if (parseFloat(input.value) <= 0) {
        input.setCustomValidity(input.getAttribute('data-message'));
    } else {
        input.setCustomValidity('');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    let form = document.querySelector('form');
    let sourceCurrencySelect = document.querySelector('select[name="source_currency"]');
    let targetCurrencySelect = document.querySelector('select[name="target_currency"]');
    let convertButton = document.querySelector('button[type="submit"]');

    form.addEventListener('submit', function(event) {
        if (sourceCurrencySelect.value == targetCurrencySelect.value) {
            event.preventDefault();
            alert(convertButton.getAttribute('data-message'));
        }
    });
});