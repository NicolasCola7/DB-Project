<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
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
    table {
        margin-top: 10px;
        border: 1px solid black;
        width: 40%;
    }
    table tr th, table tr td{
        border: 1px solid black;
        padding: 5px;
    }
    table tr td:last-child{
        width: 100px;
    }
    table th{
        background-color: black;
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
<script>
    document.addEventListener("DOMContentLoaded",function(){
        const main = document.getElementsByClassName("contenutoMain")[0];
        const urlParam = new URLSearchParams(window.location.search);
        const nomeProgetto = urlParam.get('nomeProgetto');
        const nomeProfilo = urlParam.get('nomeProfilo');
        getSkill();

        async function getSkill() {
            try{
                //eseguo una chiamata asincrona get all'url specificato inserendo un parametro in get (nome del progetto e nome profilo)
                const risposta = await axios.get("/home/info-progetto/profilo-controller", {
                    params: { nomeProgetto: nomeProgetto, nomeProfilo: nomeProfilo}
                });
                let skill = risposta.data;
                stampaSkill(skill, nomeProfilo);
            }catch(error){
                console.log(error);
            }
        }
        function stampaSkill(skills,profilo){
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

            main.appendChild(div);
        }
    })
</script>