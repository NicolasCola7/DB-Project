<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/skills/gestione-skills.style.css'>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Gestione Skills</h3>

            <section id='aggiunta'>
                <h4>Aggiungi</h4>
                <form action='/admin/home/gestione-skills' method='POST'>
                    <input type="text" name='nome' id='aggiunta' placeholder="Nome della Skill">
                    <button type='submit' id='aggiungi-skill'>+</button>
                </form>
            </section>

            <section id='skills'>
            <h4>Modifica</h4>
            <p>Queste sono le skill. Puoi rimuoverle o aggiungerne di nuove.</p>
                <?php if(count($skills) > 0): ?>
                    <?php foreach($skills as $skill): ?>
                        <div class='skill'>
                            <span class='nome-skill'> <?= htmlspecialchars($skill['nome']); ?> </span>
                            <form action='/admin/home/gestione-skills/<?= urlencode($skill['nome']); ?>' method='POST'>
                                <input type='hidden' name='_metodo' value='DELETE'>
                                <button type='submit' class='elimina-btn'>-</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <p>Non hai ancora aggiunto alcuna skill.</p>
                <?php endif; ?>
            </section>

            <div id="errori">
                <?php if (isset($errori['nome'])) : ?>
                    <p> <?= $errori['nome'] ?> </p>
                <?php endif; ?>

                <?php if (isset($errori['procedura'])) : ?>
                    <p> <?= $errori['procedura'] ?> </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>

</html>