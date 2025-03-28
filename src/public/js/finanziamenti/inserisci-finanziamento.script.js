const rewards = document.querySelectorAll('.reward');
const codiceReward = document.getElementById('codice-reward');
const form = document.getElementById('form-finanziamento');
const btnFinanzia = document.getElementById('btnFinanzia');
const sommaRicevuta = document.getElementById('ricevuti').value;
const budgetAvvio = document.getElementById('budget').value;

rewards.forEach(reward => {
    reward.addEventListener('click', function() {
        // Elimino il valore del codice reward selezionata
        codiceReward.value= "";

        // Rimuovo la marcatura di reward selezionata da tutte le righe dell atabella
        rewards.forEach(r => r.classList.remove('reward-selezionata'));
        
        // Marco come selezionata la reward 
        this.classList.add('reward-selezionata');
        
        // Imposta il valore dell'input nascosto
        codiceReward.value = this.getAttribute('data-code');
    });
});

btnFinanzia.addEventListener('click', event => {
    event.preventDefault();
    const importo = document.getElementById('importo');
    const importoValue = normalizza(importo.value);
    //controllo degli errori
    if(codiceReward.value === "") {
        AlertManager.error('Per finanziare il progetto devi selezionare una reward!');
    } else if(isNaN(importoValue) || importoValue <= 0){
        AlertManager.error('Inserisci un importo valido');
        importo.value = "";
    } else if(importoValue > 999999999.99) {
            AlertManager.error('Importo troppo grande!');
    } else {
        const sommaTotale = importoValue + parseFloat(sommaRicevuta);
        if (sommaTotale > parseFloat(budgetAvvio)) {
            AlertManager.confirmAction({
                title: "Superamento budget",
                text: `Attenzione! Con questo finanziamento il progetto supererebbe il budget d'avvio (${budgetAvvio}€). Vuoi procedere comunque?`,
                onConfirm: () => form.submit()
            });
        } else {
            AlertManager.confirmAction({
                title: "Sei sicuro?",
                text: "Vuoi finanziare veramente questo progetto?",
                onConfirm: () => form.submit()
            });
        }
    }
});

document.querySelectorAll("progress").forEach(progress => {
    let value = parseFloat(progress.value);

    let color = "#4caf50"; // verde di default
    if (value > 70 && value < 100) {
        color = "#ff9800"; // arancione
    } else if (value >= 100) {
        color = "#f44336"; // rosso
    }

    progress.style.setProperty('--progress-color', color);
});
