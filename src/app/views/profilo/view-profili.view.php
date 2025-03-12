<!DOCTYPE html>
<html>
<head>
    <title>Profili</title>
</head>
<style>
    html, body {
        height: 100vh; 
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        overflow: hidden; 
    }    
        
    .main {
        display: flex;
        flex-grow: 1; 
        overflow: hidden; 
    }

    .contenutoMain {
        flex-grow: 1;
        max-height: 100%;
        overflow-y: auto; 
        padding: 20px;
        margin: 10px;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 20px;
    }

    .contenutoMain h3 {
        color: #333;
        font-size: 24px;
        margin-bottom: 15px;
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
    

    <?php if (isset($_SESSION["utente"]['errore_candidatura'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Errore di inserimento!",
                    text: "<?php echo $_SESSION["utente"]['errore_candidatura']; ?>",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        </script>
        <?php unset($_SESSION["utente"]['errore_candidatura']); // Elimina il messaggio di errore dopo averlo mostrato ?>
    <?php elseif (isset($_SESSION["utente"]['esito_candidatura'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Successo!",
                    text: "<?php echo $_SESSION["utente"]['esito_candidatura']; ?>",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            });
        </script>
        <?php unset($_SESSION["utente"]['esito_candidatura']); // Elimina il messaggio di successo dopo averlo mostrato ?>
    <?php endif; ?>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(){
        const main = document.getElementsByClassName("contenutoMain")[0];
        const urlParam = new URLSearchParams(window.location.search);
        const nomeProgetto = urlParam.get('nomeProgetto');
        //mi salvo se l'utente è un creatore oppure no utilizzando la variabile di sessione
        const isCreatore = <?php echo isset($_SESSION["utente"]["creatore"]) && $_SESSION["utente"]["creatore"] == true ? 'true' : 'false';?>;
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
            let h3 = document.querySelector(".contenutoMain h3");
            h3.textContent = h3.textContent + " - progetto "+nomeProgetto;
            if(profili.length !== 0){
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
                    
                    //se l'utente è un creatore deve avere la possibilità di visualizzare le candidature 
                    //ricevute al progetto per poi valutarle
                    if(isCreatore){
                        let buttonViewCandidature = document.createElement("button");
                        buttonViewCandidature.textContent = "Visualizza candidature";
                        buttonViewCandidature.addEventListener("click", function(){
                            let encodedNomeProgetto = encodeURIComponent(nomeProgetto);
                            let encodedNomeProfilo = encodeURIComponent(p.nome);
                            window.location.href = `/home/info-progetto/profilo/candidature?nomeProgetto=${encodedNomeProgetto}&nomeProfilo=${encodedNomeProfilo}`;
                        })
                        div.appendChild(buttonViewCandidature);
                        div.style.width = "700px";
                    }

                    main.appendChild(div);
                });
            }else{
                let p = document.createElement("p");
                p.textContent = "Non sono presenti profili disponibili per questo progetto.";
                main.appendChild(p);
            }
        }
    })
</script>