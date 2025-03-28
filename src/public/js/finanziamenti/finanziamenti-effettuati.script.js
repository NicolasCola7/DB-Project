document.addEventListener("DOMContentLoaded", function () {
    const tooltip = document.createElement("div");
    const filtroProgetti = document.getElementById("filtroProgetti");
    const finanziamenti = document.querySelectorAll(".finanziamento");

    tooltip.className = "tooltip-reward";
    document.body.appendChild(tooltip);

    const imgRewards = document.querySelectorAll(".fotoReward");

    imgRewards.forEach(img => {
        img.addEventListener("mouseenter", (event) => {
            tooltip.textContent = img.getAttribute("data-descrizione");
            tooltip.style.display = "block";
        });

        img.addEventListener("mousemove", (event) => {
            tooltip.style.top = (event.pageY + 10) + "px";
            tooltip.style.left = (event.pageX + 10) + "px";
        });

        img.addEventListener("mouseleave", () => {
            tooltip.style.display = "none";
        });
    });

    filtroProgetti.addEventListener("change", function () {
        const filtro = this.value;

        finanziamenti.forEach(finanziamento => {
            const nomeProgetto = finanziamento.getAttribute("data-progetto") || "";
            if (filtro === "tutti" || nomeProgetto === filtro) {
                finanziamento.style.display = "flex";  // Usa "flex" se usi il flexbox, altrimenti "block"
            } else {
                finanziamento.style.display = "none";
            }
        });
    });
});