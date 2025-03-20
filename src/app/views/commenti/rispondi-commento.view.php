<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/commenti/rispondi-commento.style.css'>
    
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Rispondi al commento</h3>
            
            <div class="commento">
                    <div class="intestazione">
                        <p><?= $commento['nickname']; ?> - <?= $commento['data']; ?></p>
                    </div>
                    <div class="corpo">
                        <p><?= $commento['commento']; ?></p>
                    </div>
                    <div class="risposta">
                        <form action="/home/i-miei-progetti/<?= explode('/', $_SERVER['REQUEST_URI'])[3]; ?>/commenti/<?= explode('/', $_SERVER['REQUEST_URI'])[5] ?>/rispondi" method="post">
                            <textarea name="contenuto" placeholder="Scrivi la tua risposta" required></textarea>
                            <button type="submit">Invia messaggio</button>
                        </form>
                    </div>
                </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector(".risposta form");
        const textarea = form.querySelector("textarea");

        form.addEventListener("submit", function(event) {
            if (!textarea.value.trim()) {
                event.preventDefault(); 
                Swal.fire({
                    title: "Attenzione",
                    text: "Non puoi inviare un messaggio vuoto.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "my-confirm-button",
                    }
                })
            }
        });
    });
</script>
</html>
