const annullaForm = document.getElementById('annulla');

annullaForm.addEventListener('submit', event => {
    event.preventDefault();
    AlertManager.confirmAction({
        title: "Sei sicuro?",
        text: "Vuoi davvero eliminare tutti i dati inseriti fino a d'ora?",
        onConfirm: () => annullaForm.submit()
    });
});

const submitForm = document.getElementById('creaProgetto');

submitForm.addEventListener('submit', event => {
    event.preventDefault();
    AlertManager.confirmAction({
        title: "Sei sicuro?",
        text: "Vuoi davvero creare questo progetto?",
        onConfirm: () => submitForm.submit()
    });
});