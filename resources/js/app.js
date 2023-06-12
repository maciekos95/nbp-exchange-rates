let languageButtons = document.querySelectorAll('.lang-button');

languageButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        let language = this.getAttribute('data-lang');
        let request = new XMLHttpRequest();
        request.open('GET', 'set-language?language=' + language, true);
        request.onload = function() {
            if (request.status === 200) {
                location.reload();
            }
        };
        request.send();
    });
});