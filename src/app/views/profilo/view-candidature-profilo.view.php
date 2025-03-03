<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
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
    .contenutoMain h3 {
        color: #333;
        font-size: 24px;
    }

    .divCandidature{
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .candidatura {
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 500px; 
        height: 50px;
        padding: 15px;
        display: flex;
        gap:15px;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .candidatura:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .candidatura p {
        margin: 0;
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        color: white;
    }
    .candidatura span{
        font-weight: bold;
    }
    .candidatura button {
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
            <h3>Candidature</h3>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded",function(){
        const main = document.getElementsByClassName("contenutoMain")[0];
        const urlParam = new URLSearchParams(window.location.search);
        const nomeProgetto = urlParam.get('nomeProgetto');
        const nomeProfilo = urlParam.get('nomeProfilo');

        getCandidature();

        async function getCandidature() {
            try{
                //eseguo una chiamata asincrona get all'url specificato inserendo un parametro in get (nome del progetto e nome profilo)
                const risposta = await axios.get("/home/info-progetto/profilo/candidature-controller", {
                    params: { nomeProgetto: nomeProgetto, nomeProfilo: nomeProfilo}
                });
                let candidature = risposta.data;
                console.log(candidature);
                stampaCandidature(candidature);
            }catch(error){
                console.log(error);
            }
        }
        function stampaCandidature(candidature){
            let p1 = document.createElement("p");
            p1.textContent = "Profilo: "+nomeProfilo;
            let p2 = document.createElement("p");
            p2.textContent = "Progetto: "+nomeProgetto;
            main.appendChild(p1);
            main.appendChild(p2)
            if(candidature.length !== 0){
                let divCandidature = document.createElement("div");
                divCandidature.classList.add("divCandidature");
                candidature.forEach(c => {
                    let div = document.createElement("div");
                    div.classList.add("candidatura");

                    let p = document.createElement("p");
                    p.textContent = "Candidato: ";

                    let spanP = document.createElement("span");
                    spanP.textContent = c.nome + " "+c.cognome;
                    p.appendChild(spanP);

                    let button = document.createElement("button");
                    button.textContent = "Vedi dettagli";
                    button.addEventListener("click",function(){
                    })
                    
                    if(c.stato === "chiusa" && c.risultato === 0){
                        div.style.backgroundColor = "#FF4A4A";
                        button.style.backgroundColor = "#B00000";
                    }else if(c.stato === "chiusa" && c.risultato === 1){
                        div.style.backgroundColor = "#00CB44";
                        button.style.backgroundColor = "#008037";
                    }else if(c.stato === "aperta" && c.risultato === 0){
                        button.style.backgroundColor = "#0077cc";
                        p.style.color = "black";
                    }
                    div.appendChild(p);
                    div.appendChild(button);

                    divCandidature.appendChild(div);
                });

                main.appendChild(divCandidature);
            }
        }
    })
</script>