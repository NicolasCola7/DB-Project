<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<style>
    .container{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .divInfo{
        display: flex;
        flex-direction: column;
        gap:10px;
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #555;
        border-radius: 10px;
        width: 50%;
        margin-bottom: 25px;
    }
    .container input{
        width: 400px;
        height:30px;
        font-size: 14px;
    }
    table {
        margin-top: 10px;
        border: 1px solid black;
        width: 100%;
        text-align: center;
    }
    table tr th, table tr td{
        border: 1px solid black;
        padding: 5px;
    }
    table th{
        background-color: black;
        color: white;
    }
    .contenutoMain {
        margin: 20px;
    }
    .contenutoMain h3 {
        color: #333;
        font-size: 24px;
        margin-bottom: 15px;
    }
</style>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const main = document.getElementsByClassName("contenutoMain")[0];
        const urlParam = new URLSearchParams(window.location.search);
        const nomeProgetto = urlParam.get('nomeProgetto');
        const nomeProfilo = urlParam.get('nomeProfilo');
        const emailCandidato = urlParam.get('email');
        getInfo();

        async function getInfo() {
            try {
                //eseguo una chiamata asincrona al controller passando due parametri
                const risposta = await axios.get("/home/info-progetto/profilo/check-candidatura-controller", {
                    params: { nomeProgetto: nomeProgetto, nomeProfilo: nomeProfilo , email: emailCandidato}
                });
                let dati = risposta.data;
                console.log(dati);
                stampa(dati);
            } catch (error) {
                console.log(error);
            }
        }
        function stampa(dati){
            let h3 = document.createElement("h3");
            h3.textContent = "Dettagli candidatura";
            main.appendChild(h3);
            
            const infoCandidato = dati[0][0];
            const skillPossedute = dati[1];
            const skillRichieste = dati[2];
            const skillExtra = dati[3];

            stampaDatiCandidato(infoCandidato);
            stampaSkillProfilo(skillPossedute,skillRichieste);
            stampaSkillExtra(skillExtra);
        }
        function stampaDatiCandidato(infoCandidato){
            let divInfo = document.createElement("div");
            divInfo.classList.add("divInfo");
            main.appendChild(divInfo);

            let h4 = document.createElement("h4");
            h4.textContent = "Candidato";
            divInfo.appendChild(h4);

            //metodo che mi stampa un dato del candidato
            function createInfoField(label, value) {
                let container = document.createElement("div");
                container.classList.add("container");

                let p = document.createElement("p");
                p.textContent = label;
                container.appendChild(p);

                let input = document.createElement("input");
                input.type = "text";
                input.value = value;
                input.disabled = true;
                container.appendChild(input);

                return container;
            }

            //stampo i dati del candidato
            divInfo.appendChild(createInfoField("Nome e cognome:", infoCandidato.nome + " " + infoCandidato.cognome));
            divInfo.appendChild(createInfoField("Email:", infoCandidato.email));
            divInfo.appendChild(createInfoField("Luogo di nascita:", infoCandidato.luogo_nascita));
            divInfo.appendChild(createInfoField("Anno di nascita:", infoCandidato.anno_nascita));
        }
        function stampaSkillProfilo(skillPossedute,skillRichieste){
            let skillDiv = document.createElement("div");
            skillDiv.classList.add("divInfo");
            main.appendChild(skillDiv);

            let h4 = document.createElement("h4");
            h4.textContent = "Skill richieste";
            skillDiv.appendChild(h4);

            
            let table = document.createElement("table");
            let tr = document.createElement("tr");
            table.appendChild(tr);
            skillDiv.appendChild(table);

            let th1 = document.createElement("th");
            th1.textContent = "NOME";
            tr.appendChild(th1);

            let th2 = document.createElement("th");
            th2.textContent = "LIVELLO RICHIESTO";
            tr.appendChild(th2);

            let th3 = document.createElement("th");
            th3.textContent = "LIVELLO POSSEDUTO";
            tr.appendChild(th3);
            let i = 0;
            skillPossedute.forEach(sk_p => {
                let tr = document.createElement("tr");
                table.appendChild(tr);

                let td1 = document.createElement("td");
                td1.textContent = sk_p.nomeSkill;

                let td2 = document.createElement("td");
                td2.textContent = skillRichieste[i].livello;

                let td3 = document.createElement("td");
                td3.textContent = sk_p.livello;

                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                i = i + 1;
            });
        }
        function stampaSkillExtra(skillExtra){
            let divSkill = document.createElement("div");
            divSkill.classList.add("divInfo");
            main.appendChild(divSkill);

            let h4 = document.createElement("h4");
            h4.textContent = "Ulteriori skill possedute dal candidato";
            divSkill.appendChild(h4);
        }
    });
</script>