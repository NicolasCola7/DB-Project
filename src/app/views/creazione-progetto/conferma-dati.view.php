<?php

//se l'utente non ha inserito le informazioni base lo redirigo alla pagina apposita
if(!isset($_SESSION['creazione-progetto']) || !$_SESSION['creazione-progetto']['step1']) {
    header('location: /home/crea-progetto/informazioni-base');
    exit();
}

//se l'utente, a seconda del tipo di progetto, non ha inserito rewards o profuli lo redirigo alle pagine apposite 
if(!$_SESSION['creazione-progetto']['step4']) {
    header('location: /home/crea-progetto/rewards');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insermento componenti</title>
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

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        /* Section headers */
        .section-header {
            background-color:rgb(243, 243, 243);
            color: black;
            padding: 10px 15px;
            margin: 20px 0 0px 0;
            font-size: 16px;
            font-weight: bold;
            width:80%;
        }

        /* Table styles */
        table {
            margin-bottom: 20px;
            width: 80%;
            border-collapse: collapse;
            border: 1px solid #aaa;
        }

        th, td {
            padding: 10px;
            border: 1px solid #aaa;
            text-align: left;
        }

        th {
            background-color: #0077cc;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #d8eaff;
        }

        section > div {
            margin-bottom: 30px;
        }

        /* Profile styles */
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
            color: #0077cc;
        }

        .posizioni-profilo {
            background-color: #e6f3ff;
            color: #0066cc;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 14px;
        }

        /* Skills section toggle */
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

        /* Image styles */
        img {
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
            border-radius: 3px;
        }

        .container-btn {
            display:flex;
            justify-content: space-between;
            width: 80%;
        }

        /* Button styles (for prosegui function) */
        #crea {
            background-color: #0077cc;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;  
            margin-top: 20px;
        }

        #crea:hover {
            background-color: #005fa3;
        }

        #elimina {
            background-color:rgb(204, 0, 0);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;  
            margin-top: 20px;
        }

        #elimina:hover {
            background-color:rgb(163, 0, 0);
        }
    </style>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Conferma dati</h3>

            <section>
                <div class="section-header">Informazioni Base del Progetto</div>
                <div id='info-base'>
                    <table>
                        <thead>
                            <tr>
                                <th> Nome </th>
                                <th> Data limite </th>
                                <th> Descrizione </th>
                                <th> Budget </th>
                                <th> Tipo </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td id='nome-progetto'> <?= $_SESSION['creazione-progetto']['nome']; ?> </td>
                                <td id='data-limite'> <?= $_SESSION['creazione-progetto']['data-limite']; ?> </td>
                                <td id='descrizione'> <?= $_SESSION['creazione-progetto']['descrizione']; ?> </td>
                                <td id='budget'> <?= $_SESSION['creazione-progetto']['budget']; ?> </td>
                                <td id='tipo'> <?= $_SESSION['creazione-progetto']['tipo']; ?> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <?php if($_SESSION['creazione-progetto']['tipo']=== 'hardware'): ?>
                    <div class="section-header">Componenti Hardware</div>
                <?php else: ?>
                    <div class="section-header">Profili Software Richiesti</div>
                <?php endif; ?>
                
                <div id='<?= ($_SESSION['creazione-progetto']['tipo']=== 'software' ? 'profili' : 'componenti'); ?>'>
                    <?php if($_SESSION['creazione-progetto']['tipo'] === 'hardware') :?>
                        <table id='tabella-componenti'>
                            <thead>
                                <tr>
                                <th> Nome componente </th>
                                <th> Descrizione </th>
                                <th> Quantità </th>
                                <th> Prezzo </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach($_SESSION['creazione-progetto']['componenti'] as $componente): ?>
                                    <tr>
                                        <td class='nome-componente'> <?= $componente['nome']; ?> </td>
                                        <td class='descrizione-componente'> <?= $componente['descrizione']; ?> </td>
                                        <td class='quantità-componente'> <?= $componente['quantità']; ?> </td>
                                        <td class='prezzo-componente'> <?= $componente['prezzo']; ?> </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
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
                    <?php endif; ?>
                </div>

                <div class="section-header">Foto del progetto</div>
                <div id='foto'>
                    <table>
                        <thead>
                            <tr>
                                <th> Descrizione </th>
                                <th> Foto </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($_SESSION['creazione-progetto']['foto'] as $foto): ?>
                                <tr>
                                    <td> <?= $foto['descrizione']; ?> </td>
                                    <td> <img src='../../../<?= $foto['percorso']; ?>'> </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="section-header">Rewards del Progetto</div>
                <div id='rewards'>
                    <table>
                        <thead>
                            <tr>
                                <th> Descrizione </th>
                                <th> Foto </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($_SESSION['creazione-progetto']['rewards'] as $reward): ?>
                                <tr>
                                    <td> <?= $reward['descr']; ?> </td>
                                    <td> <img src='../../../<?= $reward['urlFoto']; ?>'> </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class='container-btn'>
                    <form action='/home/crea-progetto/annulla' id='annulla' method='POST'>
                        <input type='hidden' name='_metodo' value='DELETE'>
                        <button type='submit' id='elimina'> Annulla ed Elimina </button>
                    </form>
                    <form action='/home/crea-progetto/conferma-dati' method='POST'>
                        <button id='crea' type='submit'> Conferma e Crea </button>
                    </form>
                </div>
            </section>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>

<script>
    const annullaForm = document.getElementById('annulla');
    annullaForm.addEventListener('submit', event => {
        event.preventDefault();

        const confermaAnnullamento = confirm('Continuando tutti i dati inseriti saranno eliminati e dovrai ricominciare da capo, sei sicuro di voler continuare?');
  
        if (confermaAnnullamento) {
            annullaForm.submit();
        }
    });

    function toggleSkills(index) {
        const skillsContainer = document.getElementById('skills-container-' + index);
        const arrow = document.getElementById('arrow-' + index);
        
        skillsContainer.classList.toggle('hidden');
        arrow.classList.toggle('up');
    }
</script>
</html>