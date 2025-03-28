const nomeProgetto = document.getElementById('nomeProgetto').textContent;
const nomeProfilo = document.getElementById('nomeProfilo').textContent;

//Filtra l'elenco delle candidature in base allo stato selezionato dal menu a tendina e aggiorna la visualizzazione
function filtraCandidature(filtro) {
    switch(filtro) {
        case "accettata":
            window.location.href = `/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/candidature?filtro=accettata`;
            break;
        case "rifiutata" :
            window.location.href = `/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/candidature?filtro=rifiutata`;
            break;
        case "aperta" :
            window.location.href = `/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/candidature?filtro=aperta`;
            break;
        case "tutte":
            window.location.href = `/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/candidature`;
            break;
        default:
            break;
    }
}

function dettagliCandidatura(id) {
    window.location.href = `/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/candidature/${id}`;
}
