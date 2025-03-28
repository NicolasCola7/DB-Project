document.addEventListener("DOMContentLoaded", function () {
    const tooltip = document.getElementById("tooltip-progress");
    const searchInput = document.getElementById("searchInput");
    const statusFilter = document.getElementById("statusFilter");
    const noProjectsMessage = document.getElementById("noProjectsMessage");

    document.querySelectorAll("progress").forEach(progress => {
        // Cambia colore della barra in base al valore
        let value = parseFloat(progress.value);

        // coloro di verde se la percentuale è minore del 70%, di arancione se è tra il 70% e il 100% e di rosso se è uguale al 100%
        if (value <= 70) 
        {
            progress.style.setProperty("--progress-color", "#4caf50");
        } 
        else if (value > 70 && value < 100) 
        {
            progress.style.setProperty("--progress-color", "#ff9800");
        } 
        else 
        {
            progress.style.setProperty("--progress-color", "#f44336");
        }

        // Mostra il tooltip quando il mouse passa sopra
        progress.addEventListener("mouseenter", (event) => {
            tooltip.style.display = "block";
        });

        // Sposta il tooltip mentre il mouse si muove
        progress.addEventListener("mousemove", (event) => {
            tooltip.style.top = (event.pageY + 10) + "px"; 
            tooltip.style.left = (event.pageX + 10) + "px";
        });

        // Nasconde il tooltip quando il mouse esce
        progress.addEventListener("mouseleave", () => {
            tooltip.style.display = "none";
        });
    });

    //metodo richiamato ad ogni evento di input o change dei filtri
    function filterProjects() {
        const filter = searchInput.value.toLowerCase();
        const selectedStatus = statusFilter.value;
        const selectedType = typeFilter.value;
        const cards = document.querySelectorAll(".grid .card");
        let visibleCount = 0;

        cards.forEach(card => {
            //leggo il nome, lo stato e il tipo di ogni progetto
            const nomeProgetto = card.querySelector("#nomeProgetto p").textContent.toLowerCase();
            const statoProgetto = card.querySelector("#stato p").textContent.toLowerCase();
            const tipoProgetto = card.getAttribute("data-type").toLowerCase();

            //controllo se la stringa inserita nel filtro è inclusa nel filtro
            const matchesName = nomeProgetto.startsWith(filter);
            //controllo lo stato stato
            const matchesStatus = (selectedStatus === "tutti") || (statoProgetto === selectedStatus);
            const matchesType = (selectedType === "tutti") || (tipoProgetto === selectedType);

            if (matchesName && matchesStatus && matchesType) {
                card.parentElement.style.display = "inline-block";
                visibleCount++;
            } else {
                card.parentElement.style.display = "none";
            }
        });

        //se non ci sono progetti visualizzati visualizzo il paragrafo
        noProjectsMessage.style.display = (visibleCount === 0) ? "block" : "none";
    }

    searchInput.addEventListener("input", filterProjects);
    statusFilter.addEventListener("change", filterProjects);
    typeFilter.addEventListener("change", filterProjects);
});