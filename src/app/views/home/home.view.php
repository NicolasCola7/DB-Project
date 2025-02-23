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
            <h3>Bentornato/a <?php echo($_SESSION['utente']['nickname']) ?> su Bostarter!</h3>
            <p>Seleziona un'opzione dal menu per iniziare.</p>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>
</html>