<?php
use core\AlertManager;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/creazione-progetto/inserimento-profili.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/public/js/AlertManager.js"></script>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3> Inserimento profili </h3>

            <main>
                <div>
                    <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'crea-progetto'): ?>
                        <form action='/home/crea-progetto/software/profili' method='POST' id='form-profilo'>
                    <?php else: ?>
                        <form action='/home/i-miei-progetti/<?= explode('/', $_SERVER['REQUEST_URI'])[3] ?>/profili' method='POST' id='form-profilo'>
                    <?php endif; ?>

                        <section>
                            <div class='container'>
                                <label for='nome'> Nome Profilo </label>
                                <input type='text' name='nome' required>
                            </div>

                            <div class='container'>
                                <label for='posizioni'> Posizioni disponibili </label>
                                <input type='number' name='posizioni' required>
                            </div>
                        </section>

                        <label for='skills-richieste'> Skills richieste </label>

                        <section id='skills-richieste' name='skills-richieste'>
                        
                            <div id='skills' >

                            </div>
                            <div id='aggiunta'>
                                <select id='skills-disponibili' name='nome-skill'>
                                    <option value="" disabled selected>Scegli una skill</option>
                                    <?php if(count($skills) > 0): ?>
                                        <?php foreach($skills as $skill): ?>
                                            <option value="<?= htmlspecialchars($skill['nome']) ?>">
                                                <?= htmlspecialchars($skill['nome']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <select  name='livello' id='livello-richiesto'>
                                    <option value="" disabled selected>Scegli un livello</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>

                                <button type="button" id="aggiungi-skill" onclick="aggiungiSkill()">+</button>
                            </div>
                        </section>

                        <div class='container-bottoni'>
                            <button id='aggiungi' type='submit'> Aggiungi </button>
                        </div>
                    </form>
                </div>
                
                <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'crea-progetto'): ?>
                    <div id='container-profili'>
                        <?php if(count($_SESSION['creazione-progetto']['profili']) > 0): ?>
                            <?php foreach($_SESSION['creazione-progetto']['profili'] as $index => $profilo): ?>
                                <div class='profilo'>
                                    <div class='header-profilo'>
                                        <h2 class='nome-profilo'> <?= htmlspecialchars($profilo['nome']); ?> </h2>
                                        <span class='posizioni-profilo'> <?= htmlspecialchars($profilo['numero_posizioni']); ?> posizioni </span>
                                    </div>
                                    <div class="skills-header" onclick="toggleSkills(<?= $index ?>)">
                                        <span id="arrow-<?= $index ?>" class="arrow"></span>
                                        <span>Skills</span>
                                    </div>
                                    <div id="skills-container-<?= $index ?>" class="skills-container hidden">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td> Skill </td>
                                                    <td> Livello </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($profilo['skills-richieste'] as $skill): ?>
                                                    <tr>
                                                        <td> <?= htmlspecialchars($skill['nomeSkill']); ?> </td>
                                                        <td> <?= htmlspecialchars($skill['livello']); ?> </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p> Nessun profilo inserito </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </main>
            
            <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'crea-progetto'): ?>
                <div class='container-bottoni'>
                    <button onclick='prosegui()'> Prosegui </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show() ?>
</body>
<script src='/public/js/creazione-progetto/inserimento-profili.script.js'> </script>
<script src='/public/js/creazione-progetto/gestione-skills.script.js'></script>

</html>