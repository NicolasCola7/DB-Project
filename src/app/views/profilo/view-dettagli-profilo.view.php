<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
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
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        font-family: Arial, sans-serif;
    }

    .contenutoMain h3 {
        color: #333;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .contenutoMain p {
        font-size: 16px;
        color: #555;
        margin: 10px 0;
        display: flex;
        flex-direction: column;
    }

    .contenitoreSkill {
        display: flex;
        flex-direction: column;
        gap:20px;
    }

    .contenitoreSkill button {
        width: 140px;
        height: 50px;
        border-radius: 6px;
        background-color: #0077cc;
        border: none;
        color: white;
        font-size: medium;
    }

    .contenitoreSkill button:hover {
        background-color: #1a355f;
    }

    table {
        margin-top: 10px;
        margin-bottom: 20px;
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #aaa;
        width: 40%;
    }

    th, td {
        padding: 10px;
        border: 1px solid #aaa;
        text-align: left;
    }

    th {
        background-color: #0077cc;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #d8eaff;
    }

    .swal2-popup .swal2-confirm {
        background-color: #0077cc;
        color: white;
    }

    .swal2-popup .swal2-cancel {
        background-color: red;
        color: white;
    }
</style>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Dettagli del profilo</h3>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded",function(){
        const main = document.getElementsByClassName("contenutoMain")[0];
        const urlParam = new URLSearchParams(window.location.search);
        const nomeProgetto = urlParam.get('nomeProgetto');
        const nomeProfilo = urlParam.get('nomeProfilo');
        getSkillAndPostCandidatura();
        
        async function getSkillAndPostCandidatura() {
            try{
                //eseguo una chiamata asincrona get all'url specificato inserendo un parametro in get (nome del progetto e nome profilo)
                const risposta = await axios.get("/home/info-progetto/profilo-controller", {
                    params: { nomeProgetto: nomeProgetto, nomeProfilo: nomeProfilo}
                });
                console.log(risposta.data);
                let skill = risposta.data[0];
                let postiDisponibili = risposta.data[1]
                stampaSkill(skill, postiDisponibili, nomeProfilo);
            }catch(error){
                console.log(error);
            }
        }
        function stampaSkill(skills, postiDisponibili, profilo){
            //stampo le skill ottenute dal database
            let h3 = document.querySelector(".contenutoMain h3");
            h3.textContent = h3.textContent + " - "+profilo;

            let div = document.createElement("div");
            div.classList.add("contenitoreSkill");

            let p1 = document.createElement("p");
            p1.textContent = "Di seguito sono riportate le skill, e il loro rispettivo livello, richieste per candidarsi al profilo come "+profilo+".";
            div.appendChild(p1);

            let table = document.createElement("table");
            let tr = document.createElement("tr");

            let th1 = document.createElement("th");
            th1.textContent = "Skill"
            let th2 = document.createElement("th");
            th2.textContent = "Livello richiesto";

            tr.appendChild(th1);
            tr.appendChild(th2);

            table.appendChild(tr);
            //stampo le caratteristiche delle skill in tabella
            skills.forEach(skill => {
                let tr = document.createElement("tr");

                let td1 = document.createElement("td");
                td1.textContent = skill.nomeSkill;
                let td2 = document.createElement("td");
                td2.textContent = skill.livello;
                tr.appendChild(td1);
                tr.appendChild(td2);

                table.appendChild(tr);
            });
            div.appendChild(table);

            //creo un form con un solo bottone che esegue una richiesta post e chiama un controller
            //che eseguirà l'invio della candidatura
            console.log(postiDisponibili[0].result);
            if(postiDisponibili[0].result == 1){
                let form = document.createElement("form");
                form.method = "post";
                form.action = "/home/info-progetto/profilo-invio-candidatura";

                let button = document.createElement("button");
                button.type = "submit";
                button.textContent = "Inserisci candidatura";

                //campi da passare al controller
                let inputNomeProgetto = document.createElement("input");
                inputNomeProgetto.type = "hidden";
                inputNomeProgetto.name = "nomeProgetto";

                let inputNomeProfilo = document.createElement("input");
                inputNomeProfilo.type = "hidden";
                inputNomeProfilo.name = "nomeProfilo";

                button.addEventListener("click", function (event) {
                    event.preventDefault(); 
                    let encodedNomeProgetto = encodeURIComponent(nomeProgetto);
                    let encodedNomeProfilo = encodeURIComponent(nomeProfilo);
                    inputNomeProgetto.value = nomeProgetto;
                    inputNomeProfilo.value = nomeProfilo;
                    //chiedo conferma all'utente se desiderà veramente inoltrare la candidatura
                    Swal.fire({
                        title: "Sei sicuro?",
                        text: "Vuoi inviare la tua candidatura come " + nomeProfilo + " per il progetto " + nomeProgetto + "?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Sì, procedi!",
                        cancelButtonText: "Annulla",
                        customClass: {
                            confirmButton: "my-confirm-button",
                            cancelButton: "my-cancel-button"
                        }
                    }).then((result) => {
                        //se l'utente conferma faccio submit
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                })
                form.appendChild(button);
                form.appendChild(inputNomeProgetto);
                form.appendChild(inputNomeProfilo);
                div.appendChild(form);
            }

            main.appendChild(div);
        }
    })
</script>