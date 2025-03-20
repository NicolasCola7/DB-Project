<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/i-miei-progetti/inserimento-profilo.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <header>
                <h2> Inserimento profilo </h2>
            </header>

            <main>
                <div>
                    <form action='/home/i-miei-progetti/<?= explode('/', $_SERVER['REQUEST_URI'])[3] ?>/profili' method='POST' id='profilo'>
                        <section id='info-profilo'>
                            <div class='container'>
                                <label for='nome'> Nome Profilo </label>
                                <input type='text' name='nome' required>
                            </div>

                            <div class='container'>
                                <label for='posizioni'> Posizioni disponibili </label>
                                <input type='number' name='posizioni' min='1' required>
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
                        
                        <div class='container bottoni'>
                            <button id='aggiungi' type='submit'> Aggiungi Profilo </button>
                        </div>
                    </form>
                </div>

                <div id='errori'>
                    <?php if(isset($errori['nome'])): ?>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                Swal.fire({
                                    title: "Errore di inserimento!",
                                    text: "<?php echo $errori['nome']; ?>",
                                    icon: "error",
                                    confirmButtonText: "OK"
                                });
                            });
                        </script>
                    <?php elseif(isset($errori['posizioni'])): ?>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                Swal.fire({
                                    title: "Errore di inserimento!",
                                    text: "<?php echo $errori['posizioni']; ?>",
                                    icon: "error",
                                    confirmButtonText: "OK"
                                });
                            });
                        </script>
                    <?php else: ?>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                Swal.fire({
                                    title: "Errore di inserimento!",
                                    text: "<?php echo $errori['procedura']; ?>",
                                    icon: "error",
                                    confirmButtonText: "OK"
                                });
                            });
                        </script>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
    <?php require view('/home/home-footer.view.php'); ?>
</body>

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
                    alert('Questa skill è già stata aggiunta!');
                    return;
                }
            }
            
            const skill = document.createElement('div');
            skill.className = 'skill';
            skill.innerHTML = `
                <input type="hidden" name="skills[${contatoreSkills}][nome]" value="${nomeSkill}" class="nome-skill" required>
                <input type="hidden" name="skills[${contatoreSkills}][livello]" value="${livelloSkill}" required>
                <span>${nomeSkill}</span>
                <span> ${livelloSkill} </span>
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
</script>

</html>