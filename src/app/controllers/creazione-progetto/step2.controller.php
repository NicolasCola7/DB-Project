<?php


if($_SESSION['creazione-progetto']['tipo'] === 'hardware') {
    if (explode('/', $_SERVER['REQUEST_URI'])[3] === 'software')
        abort();
    else
        require view('/creazione-progetto/inserimento-componenti.view.php');
} else {
    if (explode('/', $_SERVER['REQUEST_URI'])[3] === 'hardware')
        abort();
    else
        require PERCORSO_BASE.'app/controllers/creazione-progetto/software/ottieni-skills-disponibili.controller.php';
}

exit();