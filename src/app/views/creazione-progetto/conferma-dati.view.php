<?php
use \core\AlertManager;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/creazione-progetto/conferma-dati.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/public/js/AlertManager.js"></script>
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
                                <td id='nome-progetto'> <?= htmlspecialchars($_SESSION['creazione-progetto']['nome']); ?> </td>
                                <td id='data-limite'> <?= htmlspecialchars($_SESSION['creazione-progetto']['data-limite']); ?> </td>
                                <td id='descrizione'> <?= htmlspecialchars($_SESSION['creazione-progetto']['descrizione']); ?> </td>
                                <td id='budget'> <?= htmlspecialchars($_SESSION['creazione-progetto']['budget']); ?> </td>
                                <td id='tipo'> <?= htmlspecialchars($_SESSION['creazione-progetto']['tipo']); ?> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <?php if($_SESSION['creazione-progetto']['tipo'] === 'hardware'): ?>
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
                                        <td class='nome-componente'> <?= htmlspecialchars($componente['nome']); ?> </td>
                                        <td class='descrizione-componente'> <?= htmlspecialchars($componente['descrizione']); ?> </td>
                                        <td class='quantità-componente'> <?= htmlspecialchars($componente['quantita']); ?> </td>
                                        <td class='prezzo-componente'> <?= htmlspecialchars($componente['prezzo']); ?> </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
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
                    <?php endif; ?>
                </div>

                <div class="section-header">Foto del progetto</div>
                <div id='foto'>
                    <table>
                        <thead>
                            <tr>
                                <th>Descrizione</th>
                                <th>Foto</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($_SESSION['creazione-progetto']['foto'] as $foto): ?>
                                <tr>
                                    <td> <?= htmlspecialchars($foto['descrizione']); ?> </td>
                                    <td> <img src='/<?= htmlspecialchars($foto['percorso']); ?>'> </td>
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
                                <th>Descrizione</th>
                                <th>Foto</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($_SESSION['creazione-progetto']['rewards'] as $reward): ?>
                                <tr>
                                    <td> <?= htmlspecialchars($reward['descr']); ?> </td>
                                    <td> <img src='/<?= htmlspecialchars($reward['urlFoto']); ?>'> </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class='container-btn'>
                    <form action='/home/crea-progetto/annulla' id='annulla' method='POST'>
                        <input type='hidden' name='_metodo' value='DELETE'>
                        <button type='submit' id='elimina'>Annulla ed Elimina</button>
                    </form>
                    <form action='/home/crea-progetto/conferma-dati' id="creaProgetto" method='POST'>
                        <button id='crea' type='submit'>Conferma e Crea</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show(); ?>
</body>

<script src='/public/js/creazione-progetto/conferma-dati.script.js'> </script>
<script src='/public/js/creazione-progetto/gestione-skills.script.js'></script>

</html>