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
    <style>
        html, body {
            height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }    

        .main {
            display: flex;
            flex-grow: 1;
            overflow: hidden;
        }

        .contenutoMain {
            flex-grow: 1;
            max-height: 100%;
            overflow-y: auto;
            padding: 20px;
            margin: 10px;
        }

        
        .contenutoMain h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }

        section {
            margin-top: 20px;
            display: flex;
            flex-direction: row;
            gap: 5%;
            margin-bottom: 5%;
        }

        section > div:first-child > form {
            width: 50%;
            display: flex; 
            flex-direction: column;
        }

        section > div{
            flex: 1;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 25px 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
            height: 45vh;
        }

        #container-profili {
            flex: 1;
            width: 100%;
            display: flex;
            flex-direction: column;
            overflow-y: scroll;
        }

        .container {
            width: 100%;
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .container button{
            background-color:#333;
            border-radius: 100%;
            width: 40px;
            height: 40px;
        }
        .container button:hover{
            background-color:black;
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
        .contenutoMain > .container-bottoni{
            text-align: center;
        }

        button {
            width: 150px;
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
            height: 70vh;
            width: 40vw;
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

        .bottoni {
            display:flex;
            flex-direction: row;
            justify-content: space-between;
        }

        #skills-aggiunte {
            display: flex;
            flex-direction: column;
            padding: 2%;
            gap: 10px;
        }

        #skills-aggiunte > div {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 2%;
            border-bottom: 1px solid #0077cc;
            color: #0077cc;
        }
        .skills-aggiunte span:last-child{
            font-size: 16px;
            font-weight: bold;
            color: #333;
            background: #d1ecf1;
            padding: 5px 10px;
            border-radius: 5px;
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
        }

        dialog > header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        #aggiunta > form {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 3% 5%;
            cursor: pointer;
        }

        #aggiunta > form > select, input {
            width: 20%;
            border: 1px solid  #0077cc
        }

        #aggiunta form select,
        #aggiunta form input[type="number"] {
            width: 70%;
            padding: 8px 12px;
            border: 2px solid #0077cc;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            background-color: #fff;
            transition: all 0.3s ease-in-out;
        }

        #aggiunta form select:hover,
        #aggiunta form input[type="number"]:hover {
            border-color: #0056b3;
        }

        #aggiunta form select:focus{
            outline: none;
            border-color: #0077cc;
            box-shadow: 0 0 8px rgba(0, 119, 204, 0.3);
        }

        #aggiungi-skill {
            background-color: #007bff;
            color: white;
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

        #elimina{
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

        #elimina:hover {
            background-color:rgb(141, 9, 9);
        }

        #elimina:active {
            transform: scale(0.9);
        }

        
        #chiudi {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            margin: 0;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            transition: color 0.2s;
        }

        #chiudi:hover {
            color: red;
        }

        dialog::backdrop {
            background: rgba(0, 0, 0, 0.5);
        }

        .profilo {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            padding: 15px;
        }

        .header-profilo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .nome-profilo {
            margin: 0;
        }

        .posizioni-profilo {
            background-color:rgb(238, 238, 238);
            color: black;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 14px;
        }

        .skills-header {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 5px 0;
            color: #0077cc;
            font-weight: 500;
        }

        .arrow {
            display: inline-block;
            width: 0;
            height: 0;
            margin-right: 10px;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid #0077cc;
            transition: transform 0.3s;
        }

        .arrow.up {
            transform: rotate(180deg);
        }

        .skills-container {
            overflow: hidden;
            transition: max-height 0.3s ease;
            max-height: 500px;
        }

        .skills-container.hidden {
            max-height: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        thead {
            background-color: #0077cc;
            color: white;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        button:disabled {
            display: none;
        }

    </style>
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