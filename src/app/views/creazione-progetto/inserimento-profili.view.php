<?php

if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'crea-progetto') {
    // se l'utente non ha inserito le informazioni base lo redirigo alla pagina apposita
    if(!isset($_SESSION['creazione-progetto']) || !$_SESSION['creazione-progetto']['step1']) {
        header('location: /home/crea-progetto/informazioni-base');
        exit();
    }
}
use core\AlertManager;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/creazione-progetto/inserimento-profili.style.css'>
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
                        <form action='/home/crea-progetto/software/profili' method='POST' id='profilo'>
                    <?php else: ?>
                        <form action='/home/i-miei-progetti/<?= explode('/', $_SERVER['REQUEST_URI'])[3] ?>/profili' method='POST' id='profilo'>
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
                        
                            <div id='skills-container' >

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
                                <select  name='livello' id='livello'>
                                    <option value="" disabled selected>Scegli un livello</option>
                                    <option value="1" name='livello'>1</option>
                                    <option value="2" name='livello'>2</option>
                                    <option value="3" name='livello'>3</option>
                                    <option value="4" name='livello'>4</option>
                                    <option value="5" name='livello'>5</option>
                                </select>

                                <button type="button" id="aggiungi-skill">+</button>
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
    <?= AlertManager::show($errori ?? []) ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const skillsContainer = document.getElementById('skills-container');
    const disponibili = document.getElementById('skills-disponibili');
    const livello = document.getElementById('livello');
    const aggiungiSkillBtn = document.getElementById('aggiungi-skill');
    const form = document.getElementById('profilo');
    let contatoreSkills = 0;
    
    // Funzione per aggiungere una skill
    aggiungiSkillBtn.addEventListener('click', function() {
        const nomeSkill = disponibili.value;
        const livelloSkill = livello.value;
        
        if (nomeSkill && livelloSkill) {
            // Verifica se la skill è già stata aggiunta
            const esistente = document.querySelectorAll('.nome-skill');
            for (let i = 0; i < esistente.length; i++) {
                if (esistente[i].value === nomeSkill) {
                    Swal.fire({
                        title: "Errore!",
                        text: "Questa skill è già stata aggiunta!",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    return;
                }
            }
            
            const skill = document.createElement('div');
            skill.className = 'skill';
            skill.innerHTML = `
                <input type="hidden" name="skills[${contatoreSkills}][nome]" value="${nomeSkill}" class="nome-skill" required>
                <input type="hidden" name="skills[${contatoreSkills}][livello]" value="${livelloSkill}" required>
                <div>
                <span id="nome-skill-aggiunta">${nomeSkill}</span>
                <span> ${livelloSkill} </span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="elimina-skill"> - </button>
            `;
            
            skillsContainer.appendChild(skill);
            contatoreSkills++;
            
            // Reset della selezione
            disponibili.selectedIndex = 0;
            livello.selectedIndex = 0;
        }
    });
    
    
    // Validazione del form prima dell'invio
    form.addEventListener('submit', function(e) {
        const skills = document.querySelectorAll('.skill');
        
        if (skills.length === 0) {
            e.preventDefault();
            Swal.fire({
                title: "Errore!",
                text: "Devi inserire almeno una skill richiesta",
                icon: "error",
                confirmButtonText: "OK"
            });
        }
    });
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