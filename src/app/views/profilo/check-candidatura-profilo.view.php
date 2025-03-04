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
                info = risposta.data;
                console.log(info);
            } catch (error) {
                console.log(error);
            }
        }
    });
</script>