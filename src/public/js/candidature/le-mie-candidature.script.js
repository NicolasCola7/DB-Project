document.addEventListener('DOMContentLoaded', function() {
    const filtroSelect = document.getElementById('filtroCandidature');
    const candidature = document.querySelectorAll('.candidatura');

    function filtraCandidature() {
        const statoSelezionato = filtroSelect.value.trim().toLowerCase();

        candidature.forEach(card => {
            const statoCard = card.getAttribute('data-status')?.trim().toLowerCase() || 'pending';
            if (statoSelezionato === 'tutte' || statoCard === statoSelezionato) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Applichiamo subito il filtro all'avvio
    filtraCandidature();

    // Aggiungiamo l'evento di cambio selezione
    filtroSelect.addEventListener('change', filtraCandidature);
});