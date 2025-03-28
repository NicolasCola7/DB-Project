let candidati = document.getElementById('candidati');
let form = document.getElementById('candidatiForm');

const nomeProgetto = document.getElementById('nomeProgetto').textContent;
const nomeProfilo = document.getElementById('nomeProfilo').textContent;

candidati.addEventListener('click', event => {
    event.preventDefault();
    AlertManager.confirmAction({
        title: "Sei sicuro?",
        text: "Vuoi inviare la tua candidatura come " + nomeProfilo + " per il progetto " + nomeProgetto + "?",
        onConfirm: () => form.submit()
    });
});