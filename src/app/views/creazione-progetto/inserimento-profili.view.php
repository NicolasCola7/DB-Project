<?php
// se l'utente non ha inserito le informazioni base lo redirigo alla pagina apposita
if(!isset($_SESSION['creazione-progetto']) || !$_SESSION['creazione-progetto']['step1']) {
    header('location: /home/crea-progetto/informazioni-base');
    exit();
}
use core\AlertManager;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insermento profili</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/creazione-progetto/inserimento-profili.style.css'>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3> Inserimento profili </h3>

            <section>
                <div>
                    <form action='/home/crea-progetto/software/profili' method='POST' id='profilo'>
                        <div class='container'>
                            <label for='nome'> Nome Profilo </label>
                            <input type='text' name='nome' required>
                        </div>

                        <div class='container'>
                            <label for='posizioni'> Posizioni disponibili </label>
                            <input type='number' name='posizioni' required>
                        </div>

                        <div class='container'>
                            <label for='btnSkill'>Skill richieste</label>
                            <button onclick='apriDialog()' type="button" id="btnSkill">+</button>
                        </div>

                        <div class='container-bottoni'>
                            <button id='aggiungi' type='submit'> Aggiungi </button>
                        </div>
                    </form>
                </div>

                <div id='container-profili'>
                    <?php if(count($_SESSION['creazione-progetto']['profili']) > 0): ?>
                        <?php foreach($_SESSION['creazione-progetto']['profili'] as $index => $profilo): ?>
                            <div class='profilo'>
                                <div class='header-profilo'>
                                    <h2 class='nome-profilo'> <?= $profilo['nome']; ?> </h2>
                                    <span class='posizioni-profilo'> <?= $profilo['numero_posizioni']; ?> posizioni </span>
                                </div>
                                <div class="skills-header" onclick="toggleSkills(<?= $index ?>)">
                                    <span id="arrow-<?= $index ?>" class="arrow"></span>
                                    <span>Skills</span>
                                </div>
                                <div id="skills-container-<?= $index ?>" class="skills-container hidden">
                                    <table class='skills'>
                                        <thead>
                                            <tr>
                                                <td> Skill </td>
                                                <td> Livello </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($profilo['skills-richieste'] as $skill): ?>
                                                <tr>
                                                    <td> <?= $skill['nomeSkill']; ?> </td>
                                                    <td> <?= $skill['livello']; ?> </td>
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
            </section>

            <div class='container-bottoni'>
                <button onclick='prosegui()'> Prosegui </button>
            </div>
                
            <dialog id='skill-requisito'>
                <header class="dialog-header">
                    <h2>Inserisci skills richieste</h2>
                    <button type="button" id="chiudi" onclick='chiudiDialog()' aria-label="Chiudi">&times;</button>
                </header>

                <div id='aggiunta'>
                    <div id='skills-aggiunte'>
                        <?php foreach($_SESSION['creazione-progetto']['skills-richieste'] as $skill) :?>
                            <div class='skills-aggiunte'>
                                <div>
                                    <span> <?= $skill['nomeSkill']; ?> </span>
                                    <span> <?= $skill['livello']; ?> </span>
                                </div>
                                <form action='/home/crea-progetto/software/profili/skills/<?= $skill['nomeSkill']; ?>' method='POST'>
                                    <input type='hidden' name='_metodo' value='DELETE'>
                                    <button type='submit' id='elimina'> - </button>
                                </form>
                            </div>
                        <?php endforeach;  ?>
                     </div>

                    <form action='/home/crea-progetto/software/profili/skills' method='POST'>
                        <select id='skill-disponibili' name='nome-skill' required >
                            <option value="" disabled selected>Scegli una skill</option>
                            <?php if(count($skills) > 0): ?>
                                <?php foreach($skills as $skill): ?>
                                    <option name='<?= $skill['nome']; ?>'>
                                        <?= $skill['nome']; ?>
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
                        <div class='bottoni'>
                            <button type='submit' id='aggiungi-skill'> Aggiungi </button>
                        </div>
                    </form>
                </div>
            </dialog>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show($errori ?? []) ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let dialog = document.getElementById('skill-requisito');
    let aggiungiProfiloBtn = document.getElementById('aggiungi');
    let formProfilo = document.getElementById('profilo');
    let nomeProfilo = document.getElementsByName('nome')[0];

    window.addEventListener('load', () => {
        let skills = <?= count($_SESSION['creazione-progetto']['skills-richieste']); ?>;
        if(skills < 1 ){
            aggiungiProfiloBtn.disabled = true;
        } else {
            aggiungiProfiloBtn.disabled = false;
        }

        if (window.location.pathname === `/home/crea-progetto/software/profili/skills`) {
            dialog.showModal();
        }
    });

    function chiudiDialog() {
        dialog.close();
        window.location.href = '/home/crea-progetto/software/profili';
    }

    window.apriDialog = function() {
        window.location.href = `/home/crea-progetto/software/profili/skills`;
    }

    function prosegui() {
        const profili = <?= count($_SESSION['creazione-progetto']['profili']); ?>;
        if(profili < 1) {
            Swal.fire({
                title: "Attenzione!",
                text: 'Devi inserire almeno 1 profilo prima di proseguire!',
                icon: "error",
                confirmButtonText: "OK"
            });
        } else {
            <?php $_SESSION["creazione-progetto"]["step2"] = true; ?>
            window.location.href = '/home/crea-progetto/foto';
        }
    }

    function toggleSkills(index) {
        const skillsContainer = document.getElementById('skills-container-' + index);
        const arrow = document.getElementById('arrow-' + index);
        
        skillsContainer.classList.toggle('hidden');
        arrow.classList.toggle('up');
    }
</script>

</html>