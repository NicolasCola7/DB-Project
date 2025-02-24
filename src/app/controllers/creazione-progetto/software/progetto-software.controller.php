<?php 

if($_SESSION['creazione-progetto']['tipo'] !== 'software') {
    header('location: /home/crea-progetto');
    exit();
}

if(!$_SESSION['creazione-progetto']['step1']) {
    header('location: /home/crea-progetto');
    exit();
}

require view('/creazione-progetto/inserimento-profili.view.php');
exit();