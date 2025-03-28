document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector(".risposta form");
    const textarea = form.querySelector("textarea");

    form.addEventListener("submit", function(event) {
        if (!textarea.value.trim()) {
            event.preventDefault();
            AlertManager.warning('Non puoi inviare un messaggio vuoto.');
        }
    });
});