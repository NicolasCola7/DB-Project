const sezione = document.getElementById('sezione').value;

function vediDettagli(nomeProfilo, nomeProgetto){
    window.location.href = `/home/${sezione}/${nomeProgetto}/profili/${nomeProfilo}/skills-richieste`;
}

function vediCandidature(nomeProfilo, nomeProgetto) {
    window.location.href = `/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/candidature`;
}

function aggiungiProfilo(nomeProgetto) {
    window.location.href = `/home/i-miei-progetti/${nomeProgetto}/aggiungi-profilo`;
}