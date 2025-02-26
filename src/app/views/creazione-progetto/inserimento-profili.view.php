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

        section {
            margin-top: 20px;
        }

        section > form {
            max-width: 600px;
            margin: 0 auto; 
        }

        .container {
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

        input, textarea {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
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

        #successo {
            color: green;
        }

        /* Dialog styling */
        dialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        dialog form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        dialog select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        dialog button {
            margin-top: 10px;
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
                <form action='/home/crea-progetto/software/profili' method='POST'>
                    <div class='container'>
                        <label for='nome'> Nome Profilo </label>
                        <input type='text' name='nome' required>
                    </div>

                    <div class='container'>
                        <label for='posizioni'> Posizioni disponibili </label>
                        <input type='number' name='posizioni' required>
                    </div>

                    <div class='container'>
                        <button id='aggiungi' type='submit'> Aggiungi </button>
                    </div>
                </form>
            </section>

            <div class='container bottoni'>
                <button onclick='prosegui()'> Prosegui </button>
                <button onclick='apriDialog()'> Inserisci skills richieste </button>
            </div>
                
            <dialog id='skill-requisito'>
                <form action='/home/crea-progetto/software/profili/skills' method='POST'>
                    <select id='skill-disponibili' name='nome-skill' required >
                    
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
                        <button type='submit' id='aggiungi-skill'> + </button>
                        <button id='chiudi' onclick='chiudiDialog()'> Chiudi </button>
                    </div>
                </form>
            </dialog>

            <div id="errori">
                <?php if (isset($errori['nome'])) : ?>
                    <p><?= $errori['nome'] ?></p>
                <?php endif; ?>
                
                <?php if (isset($errori['posizioni'])) : ?>
                    <p><?= $errori['posizioni'] ?></p>
                <?php endif; ?>

                <?php if (isset($_SESSION['aggiunta-profilo'])) : ?>
                    <?php if ($_SESSION['aggiunta-profilo']) : ?>
                        <p id='successo'> Profilo aggiunto con successo! </p>
                    <?php else :?>
                        <p> Profilo già inserito!</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    let dialog = document.getElementById('skill-requisito');
    let disponibili = document.getElementById('skill-disponibili');
    let aggiungiProfiloBtn = document.getElementById('aggiungi');
    getSkillDisponibili();

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

    // al submit del form, se non sono presenti skills, appare la dialog per inserirle
    aggiungiProfiloBtn.addEventListener('submit', event => {
        let skills = <?= count($_SESSION['creazione-progetto']['skills-richieste']); ?>;
        if(skills < 1) {
            event.preventDefault();
            apriDialog();
        }
    });
</script>

</html>