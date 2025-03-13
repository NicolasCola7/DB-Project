<!DOCTYPE html>
<html>
<head>
    <title>Insermento profili</title>
    <style>
        .contenutoMain {
            flex-grow: 1;
            max-height: 100%;
            overflow-y: auto;
            padding: 20px;
            margin: 10px;
        }

        .contenutoMain > header {
            display: flex;
            flex-direction: row;
            justify-content: center;
            color: #0077cc;
            border-bottom: 2px solid #0077cc;
            padding-bottom: 1em;
            margin-bottom: 1em;
            background: #fff;
        }

        main {
            margin-top: 20px;
            display: flex;
            flex-direction: row;
            gap: 5%;
            margin-bottom: 5%;
            justify-content: center;
        }

        main > div:first-child > form {
            width: 100%;
            margin: 0 auto; 
            display: flex; 
            flex-direction: column;
        }

        section > div:first-child {
            flex: 1;
        }

        #container-profili {
            flex: 1;
            width: 100%;
            display: flex;
            flex-direction: column;
            max-height: 50vh;
            overflow: scroll;
        }

        .container {
            width: 100%;
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .bottoni {
            margin-bottom: 15px;
            display: flex;
            gap: 10px;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .container > input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            width: 100%
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #0077cc;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
        }

        button:hover {
            background-color: #0056b3;
        }

        button:focus {
            outline: none;
            border-color: #0077cc;
            box-shadow: 0 0 8px rgba(0, 119, 204, 0.3);
        }

        .successo {
            color: green;
            text-align: center;
            margin: 10px;
        }

        #errori-skill {
            color: red;
            text-align: center;
            margin: 10px;
        }

        #skills-richieste {
            display: flex;
            flex-direction: column;
        }

        #skills-richieste {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        #skills-aggiunte {
            display: flex;
            flex-direction: column;
            padding: 2%;
            gap: 10px;
        }

        #skills-aggiunte > div {
            display: grid;
            grid-template-columns: minmax(120px, 1fr) 1fr auto;
            gap: 15px; 
            align-items: center;
            padding: 2%;
            border-bottom: 1px solid #0077cc;
            color: #0077cc;
        }

      
        #skills-aggiunte > div > span:first-child {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #skill-requisito {
            position: relative;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
        }


        #aggiunta {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 3% 5%;
            cursor: pointer;
        }

        #aggiunta select {
            width: 20%;
            padding: 8px 12px;
            border: 2px solid #0077cc;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            background-color: #fff;
            transition: all 0.3s ease-in-out;
        }

        #aggiunta select:hover {
            border-color: #0056b3;
        }

        #aggiunta select:focus{
            outline: none;
            border-color: #0077cc;
            box-shadow: 0 0 8px rgba(0, 119, 204, 0.3);
        }

        #aggiungi-skill {
            width: 30px;
            height: 30px;   
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            font-size: 24px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.2s;
        }

        #aggiungi-skill:hover {
            background-color: #0056b3;
        }

        #aggiungi-skill:active {
            transform: scale(0.9);
        }

        .elimina-skill{
            display: flex;
            width: 30px;
            height: 30px;   
            border-radius: 50%;
            background-color:rgb(255, 0, 0);
            color: white;
            font-size: 24px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            justify-content: center;
            align-items: center;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.2s;
        }

        .elimina-skill:hover {
            background-color:rgb(141, 9, 9);
        }

        .elimina-skill:active {
            transform: scale(0.9);
        }

       .skills-container {
            overflow: scroll;
            transition: max-height 0.3s ease;
            max-height: 200px;
            display: flex;
            flex-direction: column;
            padding: 2%;
            gap: 10px;
        }

        .skill {
            display: grid;
            grid-template-columns: minmax(120px, 1fr) 1fr auto;
            gap: 15px; 
            align-items: center;
            padding: 2%;
            border-bottom: 1px solid #0077cc;
            color: #0077cc;
        }

        .skill> span:first-child {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
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
                    <form action='' method='POST' id='profilo'>
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
                            <label>
                            <div id='skills-container' >

                            </div>
                            <div id='aggiunta'>
                                <select id='skills-disponibili' name='nome-skill' required >
                                    <option value="" disabled selected>Scegli una skill</option>
                                    <?php if(count($skills) > 0): ?>
                                        <?php foreach($skills as $skill): ?>
                                            <option value="<?= htmlspecialchars($skill['nome']) ?>">
                                                <?= htmlspecialchars($skill['nome']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <select required name='livello' id='livello'>
                                    <option value="" disabled selected>Scegli un livello</option>
                                    <option value="1" name='livello'>1</option>
                                    <option value="2" name='livello'>2</option>
                                    <option value="3" name='livello'>3</option>
                                    <option value="4" name='livello'>4</option>
                                    <option value="5" name='livello'>5</option>
                                </select>

                                <button type="button" id="aggiungi-skill">+</button>
                            </div>

                            <div id="errori-skills" class="errore" style="display: none;">
                                È necessario inserire almeno una skill
                            </div>
                        </section>
                        
                        <div class='container bottoni'>
                            <button id='aggiungi' type='submit'> Aggiungi Profilo </button>
                        </div>
                    </form>
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
    const erroriSkills = document.getElementById('errori-skills');
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
            
            // Nascondi il messaggio di errore se almeno una skill è stata aggiunta
            erroriSkills.style.display = 'none';
            
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
            erroriSkills.style.display = 'block';
            window.scrollTo(0, erroriSkills.offsetTop);
        }
    });

    function eliminaSkill(nomeSkill) {
        let skills = document.querySelectorAll('.skill');
        for(let i=0; i<skills.length; i++) {
            const nome = skills[i].querySelector('.nome-skill');

            if(nomeSkill && nome.value === nomeSkill) {
                skills[i].remove();
                break;
            }
        }
    }
</script>

</html>