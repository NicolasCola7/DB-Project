<?php
// se l'utente non ha inserito le informazioni base lo redirigo alla pagina apposita
if(!isset($_SESSION['creazione-progetto']) || !$_SESSION['creazione-progetto']['step1']) {
    header('location: /home/crea-progetto/informazioni-base');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insermento profili</title>
    <style>
        .contenutoMain {
            margin: 20px 10%;
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
    </style>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <header>
                <h2> Inserimento profili </h2>
            </header>

            <section>
                <div class='container'>
                    <label for='nome'> Nome Profilo </label>
                    <input type='text' name='nome' required>
                </div>

                <div class='container'>
                    <label for='posizioni'> Posizioni disponibili </label>
                    <input type='number' name='posizioni' required>
                </div>

                <div class='container'>
                    <button onclick='apriDialog()'> Inserisci skills richieste </button>
                    <button id='aggiungi' type='submit'> Aggiungi </button>
                </div>

            </section>

            <div class='container'>
                <button onclick='prosegui()'> Prosegui </button>
            </div>

            <dialog id='skill-requisito'>
                <form action='/home/crea-progetto/software/profili/skills' method='POST'>
                    <select id='skill-disponibili' name='nome' required >
                    </select>
                    
                    <select required name='livello'>
                        <option value="" disabled selected>Scegli un livello</option>
                        <option value="1" name='livello'>1</option>
                        <option value="2" name='livello'>2</option>
                        <option value="3" name='livello'>3</option>
                        <option value="4" name='livello'>4</option>
                        <option value="5" name='livello'>5</option>
                    </select>
                    
                    <button type='submit' id='aggiungi-skill'> + </button>
                    <button id='chiudi' onclick='chiudiDialog()'> Chiudi </button>
                </form>
            </dialog>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>

<script>
    let dialaog = document.getElementById('skill-requisito');
    let disponibili = document.getElementById('skill-disponibili');
    let aggiungiProfiloBtn = document.getElementById('aggiungi');
    getSkillDisponibili();
    getMieSkills();

    // al submit del form (agggiunt profilo), se non è stata aggiunta alcuna skill per quel profilo si apre la dialog per inserirle
    aggiungiProfiloBtn.addEventListener('submit',  event => {
        let nSkills = <?php count($_SESSION['creazione-progetto']['profili']['skills']); ?>
        if(nSkills < 1 ){
            event.preventDefault(); // evito il submit del form
            dialog.showModal(); // mostro la dialog per inserire skill
        }
    });

    function chiudiDialog() {
        dialog.close();
    }

    function apriDialog() {
        dialog.showModal();
    }

    async function getSkillDisponibili() {
        try {
            const risposta = await axios.get("/admin/ottieni-skills");
            let skills = risposta.data;
            
            if(skills) {
                popolaDisponibili(skills);
            }
        } catch(error) {
            console.log(error);
        }
    }

    function popolaDisponibili(skills) {
        disponibili.innerHTML = '';
        
        //aggiungo la prima opzione disabilitata e selezionata
        let defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.textContent = 'Scegli una skill';
        disponibili.appendChild(defaultOption);
        
        skills.forEach(skill => {
            
            let option = document.createElement('option');
            option.name = skill.nome;
            option.textContent = skill.nome;
            disponibili.appendChild(option);
        });
    }
</script>

</html>