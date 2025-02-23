<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <style>
        .contenutoMain {
            margin: 20px;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <h2>BOSTARTER</h2>
        </div>
        <div id='info'>
            <img src="/icona-profilo" alt='icona profilo'>
            <p><?php echo($_SESSION['utente']['nickname']) ?></p>
            <form action='/logout' method='POST'>
                <input type="submit" value='Logout'>
            </form>
        </div>
    </header>
    
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
    getInfoProgetto();

    async function getInfoProgetto(){
        try{
            const risposta = await axios.get("/home/info-progetto-controller")
            let progetto = risposta.data;
            console.log(progetto);
        }catch(error){
            console.log(error);
        }
    }
</script>
</html>