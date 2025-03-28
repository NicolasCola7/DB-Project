const form = document.getElementById('form-componenti');
const prezzo = document.getElementById('prezzo');
const quantita = document.getElementById('quantita');
const aggiungiBtn = document.getElementById('aggiungi');
const componenti = document.querySelectorAll('tbody > .componente');

form.addEventListener('submit', event => {
    event.preventDefault();

    if(prezzo.value && quantita.value) {
        if(normalizza(prezzo.value) > 999999999.99 ) {
            AlertManager.error('Il prezzo deve essere <= 999.999.999,99!');
            return;
        } 

        if(quantita.value > 999999999 ) {
            AlertManager.error('la quantità deve essere <= 999.999.999!');
            return;
        } 

        form.submit();
    }
});

function prosegui() {
    let nComponenti = componenti.length;
    if(nComponenti > 0) {
        window.location.href = "/home/crea-progetto/foto";
    } else {
        AlertManager.error('Devi inserire almeno una componente.');
    }
} 