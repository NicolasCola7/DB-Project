<!DOCTYPE html>
<html>
<head>
    <title>Profili</title>
</head>
<style>
    .contenutoMain {
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    justify-content: flex-start;
    gap: 20px;
    padding: 20px;
    margin:20px;
}

.divProfilo {
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 500px; 
    padding: 15px;
    display: flex;
    gap:15px;
    align-items: center;
    justify-content: space-between;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.divProfilo:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.divProfilo p {
    margin: 0;
    font-family: 'Arial', sans-serif;
    font-size: 14px;
    color: #333;
}

.divProfilo p:first-child {
    font-weight: bold;
    font-size: 16px;
    flex-grow: 1; /* Consente al nome di espandersi per occupare più spazio */
}

.divProfilo p:last-child {
    font-size: 14px;
    color: #666;
}

.divProfilo button {
    background-color: #0077cc;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}


</style>

<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Profili disponibili</h3>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(){
        const main = document.getElementsByClassName("contenutoMain")[0];
        const urlParam = new URLSearchParams(window.location.search);
        const nomeProgetto = urlParam.get('nomeProgetto');
        getProfili();

        async function getProfili() {
            try{
                //eseguo una chiamata asincrona get all'url specificato inserendo un parametro in get (nome del progetto)
                const risposta = await axios.get("/home/info-progetto/profili-controller", {
                    params: { nomeProgetto: nomeProgetto }
                });
                let profili = risposta.data;
                stampaProfili(profili);
            }catch(error){
                console.log(error);
            }
        }
        //metodo che crea le card per i profili disponibili
        function stampaProfili(profili){
            profili.forEach(p => {
                let div = document.createElement("div");
                div.classList.add("divProfilo");

                let p1 = document.createElement("p");
                p1.textContent = p.nome;

                let p2 = document.createElement("p");
                p2.textContent = p.numero_posizioni+" posizioni disponibili";

                let button = document.createElement("button");
                button.textContent = "Vedi dettagli";
                button.addEventListener("click",function(){
                    let encodedNomeProgetto = encodeURIComponent(nomeProgetto);
                    let encodedNomeProfilo = encodeURIComponent(p.nome);
                    window.location.href = `/home/info-progetto/profilo?nomeProgetto=${encodedNomeProgetto}&nomeProfilo=${encodedNomeProfilo}`;
                })


                div.appendChild(p1);
                div.appendChild(p2);
                div.appendChild(button);

                main.appendChild(div);
            });
        }
    })
</script>