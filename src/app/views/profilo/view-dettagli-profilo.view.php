<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
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
                console.log(skill);
            }catch(error){
                console.log(error);
            }
        }
    })
</script>