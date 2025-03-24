<?php use \core\AlertManager; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/skills/le-mie-skill.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Le mie skill</h3>
            <section id='aggiunta'>
                <h4>Aggiungi</h4>
                <form action='/home/le-mie-skill' method='POST'>
                    <select id='skill-disponibili' name='nome' required >
                        <?php if(count($skills['generali']) > 0): ?>
                            <option value="" disabled selected>Scegli una skill</option>
                            <?php foreach($skills['generali'] as $generale): ?>
                                <option name='<?= htmlspecialchars($generale['nome']); ?>'>
                                     <?= htmlspecialchars($generale['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    
                    <select required name='livello'>
                        <option value="" disabled selected>Scegli un livello</option>
                        <option value="1" name='livello'>1</option>
                        <option value="2" name='livello'>2</option>
                        <option value="3" name='livello'>3</option>
                        <option value="4" name='livello'>4</option>
                        <option value="5" name='livello'>5</option>
                    </select>
                    
                    <button type='submit' id='aggiungi-skill'>+</button>
                </form>
            </section>

            <section id='skills'>
                <h4>Modifica</h4>
                <p>Queste sono le skill, con rispettivo livello, che hai aggiunto. Puoi rimuoverle o aggiungerne di nuove.</p>
                <?php if(count($skills['possedute']) > 0): ?>
                    <?php foreach($skills['possedute'] as $posseduta): ?>

                        <div class='skill'>
                            <div>
                            <span class='nome-skill'> <?= htmlspecialchars($posseduta['nomeSkill']); ?> </span>
                            <span class='livello-skill'> <?= htmlspecialchars($posseduta['livello']); ?> </span>
                            </div>
                            <form action='/home/le-mie-skill/<?= htmlspecialchars(urlencode($posseduta['nomeSkill'])); ?>' method='POST'>
                                <input type='hidden' name='_metodo' value='DELETE'>
                                <button type='submit' class='elimina-btn'> - </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <p>Non hai ancora aggiunto alcuna skill.</p>
                <?php endif; ?>
            </section>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show($errori ?? []) ?>

</body>

</html>