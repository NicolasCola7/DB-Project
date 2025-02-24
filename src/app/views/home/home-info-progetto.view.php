<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <style>
        .contenutoMain {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            margin: 20px;
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

        .descrizione-container {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .descrizione-container textarea {
            flex: 1;
            resize: vertical;
            height: 50px;
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            color: #555;
        }
        .infoContainer, .componentiContainer, .contenitoreProfili{
            padding: 10px;
            border: 1px solid #555;
            border-radius: 10px;
            width: 70%;
            margin-bottom: 25px;
        }
        .componentiContainer table {
            margin-top: 10px;
            border: 1px solid black;
            width: 100%;
        }
        .componentiContainer table tr th, .componentiContainer table tr td{
            border: 1px solid black;
            padding: 5px;
        }
        .componentiContainer table th{
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Dettagli del progetto</h3>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded",function(){
        const main = document.getElementsByClassName("contenutoMain")[0];
        //recupero il nome del progetto dall'url
        const urlParam = new URLSearchParams(window.location.search);
        const nomeProgetto = urlParam.get('nome');
        getInfoProgetto();

        async function getInfoProgetto(){
            try{
                //eseguo una chiamata asincrona get all'url specificato inserendo un parametro in get (nome del progetto)
                const risposta = await axios.get("/home/info-progetto-controller", {
                    params: { nome: nomeProgetto }
                });
                //la risposta è un array di oggetti json che contengono le informazioni del progetto
                //il primo oggetto contiene le caratteristiche del progetto
                let progetto = risposta.data[0][0];
                //il secondo contiene le componenti del progetto
                let componenti = risposta.data[1];
                stampaCaratteristiche(progetto);
                stampaComponenti(componenti);
                creaComponenteProfili();
            }catch(error){
                console.log(error);
            }
        }
        //stampo a video le caratteristiche del progetto
        function stampaCaratteristiche(p){
            let titolo = document.querySelector("h3");
            titolo.textContent = titolo.textContent +" "+ p.nome;

            //creo un contenitore che conterrà tutte le info appartenenti alle caratteristiche del progetto
            let infoContainer = document.createElement("div");

            let titolo2 = document.createElement("h4");
            titolo2.textContent = "Informazioni";
            infoContainer.appendChild(titolo2);
            infoContainer.classList.add("infoContainer");

            //data inserimento
            let dataInserimento = document.createElement("p");
            dataInserimento.textContent = "Data di inserimento: "+p.data_inserimento;
            infoContainer.appendChild(dataInserimento);

            //data limite
            let dataFine = document.createElement("p");
            dataFine.textContent = "Data di fine: "+p.data_limite;
            infoContainer.appendChild(dataFine);

            //descrizione
            let descrContainer = document.createElement("div");
            descrContainer.classList.add("descrizione-container");            
            let descr = document.createElement("textarea");
            let par = document.createElement("p");
            descr.readOnly = true;
            par.textContent = "Descrizione: ";
            descr.textContent = p.descr;
            descrContainer.appendChild(par);
            descrContainer.appendChild(descr);
            infoContainer.appendChild(descrContainer);
            
            //stato
            let stato = document.createElement("p");
            stato.textContent = "Stato: "+p.stato;
            infoContainer.appendChild(stato);

            //budget
            let budget = document.createElement("p");
            budget.textContent = "Budget d'avvio: "+p.budget_avvio+" EUR";
            infoContainer.appendChild(budget);

            //somma finanziamenti ricevuti
            let fin = document.createElement("p");
            fin.textContent = "Somma finanziamenti ricevuti: "+p.sommaFinRicevuti+" EUR";
            infoContainer.appendChild(fin);

            //creatore
            let creatore = document.createElement("p");
            creatore.textContent = "Utente creatore: "+p.nomeC +" "+p.cognomeC;
            infoContainer.appendChild(creatore);

            //email creatore
            let emailC = document.createElement("p");
            emailC.textContent = "Email: "+p.emailCreatore;
            infoContainer.appendChild(emailC);

            main.appendChild(infoContainer);
        }
        function stampaComponenti(componenti){
            let componentiContainer = document.createElement("div");
            componentiContainer.classList.add("componentiContainer");

            let titolo = document.createElement("h4");
            titolo.textContent = "Componenti";
            componentiContainer.appendChild(titolo);

            let tabella = document.createElement("table");
            let tr = document.createElement("tr");

            let th1 = document.createElement("th");
            th1.textContent = "Nome"
            let th2 = document.createElement("th");
            th2.textContent = "Prezzo";
            let th3 = document.createElement("th");
            th3.textContent = "Descrizione";
            let th4 = document.createElement("th");
            th4.textContent = "Quantità";

            tr.appendChild(th1);
            tr.appendChild(th2);
            tr.appendChild(th3);
            tr.appendChild(th4);

            tabella.appendChild(tr);
            componenti.forEach(c => {
                let tr = document.createElement("tr");

                let td1 = document.createElement("td");
                td1.textContent = c.nome;
                let td2 = document.createElement("td");
                td2.textContent = c.prezzo;
                let td3 = document.createElement("td");
                td3.textContent = c.descr;
                let td4 = document.createElement("td");
                td4.textContent = c.quantita;

                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tr.appendChild(td4);

                tabella.appendChild(tr);
            })

            componentiContainer.appendChild(tabella);
            main.appendChild(componentiContainer);
        }
        async function creaComponenteProfili(){
            let div = document.createElement("div");
            div.classList.add("contenitoreProfili");

            let h4 = document.createElement("h4");
            h4.textContent = "Profili disponibili";

            let a = document.createElement("a");
            a.textContent = "Visualizza i profili disponibili per questo progetto";
            a.href="/home/info-progetto/profili";
            div.appendChild(h4);
            div.appendChild(a);

            main.appendChild(div);
        }
    })
</script>
</html>