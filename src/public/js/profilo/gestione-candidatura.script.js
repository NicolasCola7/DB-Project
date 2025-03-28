const nomeCandidato = document.getElementById('nome').value;
   
const nomeProgetto = document.getElementById('nomeProgetto').textContent;
const nomeProfilo = document.getElementById('nomeProfilo').textContent;

const rifiuta = document.getElementById('rifiutaForm');
const accetta = document.getElementById('accettaForm');

const rifiutaBtn = document.getElementById('rifiuta');
const accettaBtn = document.getElementById('accetta');

rifiutaBtn.addEventListener('click', event => {
    event.preventDefault();

    AlertManager.confirmAction({
        title: "Sei sicuro?",
        text: `Vuoi davvero rifiutare la candidatura di ${nomeCandidato} come ${nomeProfilo} per il progetto ${nomeProgetto}?`,
        onConfirm: () => rifiuta.submit()
    });
});

accettaBtn.addEventListener('click', event => {
    event.preventDefault();

    AlertManager.confirmAction({
        title: "Sei sicuro?",
        text: `Vuoi davvero accettare la candidatura di ${nomeCandidato} come ${nomeProfilo} per il progetto ${nomeProgetto}?`,
        onConfirm: () => accetta.submit()
    });
});