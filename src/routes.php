<?php

//GET
$router->get('/', 'app/index.php');
$router->get('/home', 'app/views/home/home.view.php')->soloSe('autenticato');
$router->get('/login', 'app/views/autenticazione/login.view.php')->soloSe('non-autenticato');
$router->get('/registrazione', 'app/views/autenticazione/registrazione.view.php')->soloSe('non-autenticato');
$router->get('/admin/login', 'app/views/autenticazione/login-admin.view.php')->soloSe('non-autenticato');
$router->get('/admin/registrazione', 'app/views/autenticazione/registrazione-admin.view.php')->soloSe('non-autenticato');
$router->get('/home/visualizza-progetti','app/views/home/home-view-progetti.view.php')->soloSe('autenticato');
$router->get('/home/visualizza-progetti-controller','app/controllers/home/home-view-progetti.controller.php')->soloSe('autenticato');
$router->get('/home/info-progetto','app/views/home/home-info-progetto.view.php')->soloSe('autenticato');
$router->get('/home/info-progetto-controller','app/controllers/home/home-info-progetto.controller.php')->soloSe('autenticato');
$router->get('/home/le-mie-skill', 'app/views/skills/le-mie-skill.view.php')->soloSe('autenticato');
$router->get('/ottieni-mie-skills', 'app/controllers/skills/non-admin/ottieni-mie-skill.controller.php')->soloSe('autenticato');
$router->get('/ottieni-skills', 'app/controllers/skills/non-admin/ottieni-skill.controller.php')->soloSe('autenticato');
$router->get('/icona-profilo', 'public/icone/icona-profilo.svg');
$router->get('/admin/home/gestione-skills', 'app/views/skills/gestione-skills.view.php')->soloSe('admin');
$router->get('/admin/ottieni-skills', 'app/controllers/skills/admin/ottieni-skills.controller.php')->soloSe('admin');
$router->get('/home/info-progetto/profili', 'app/views/profilo/view-profili.view.php')->soloSe('autenticato');
$router->get('/home/info-progetto/profili-controller', 'app/controllers/profilo/view-profili.controller.php')->soloSe('autenticato');
$router->get('/home/crea-progetto/informazioni-base', 'app/views/creazione-progetto/crea-progetto.view.php')->soloSe('creatore');
$router->get('/home/crea-progetto/hardware/componenti', 'app/controllers/creazione-progetto/hardware/progetto-hardware.controller.php')->soloSe('creatore');
$router->get('/home/crea-progetto/software/profili', 'app/controllers/creazione-progetto/software/progetto-software.controller.php')->soloSe('creatore');
$router->get('/home/crea-progetto/foto', 'app/views/creazione-progetto/inserimento-foto.view.php')->soloSe('creatore');

//POST
$router->post('/login', 'app/controllers/autenticazione/login.controller.php')->soloSe('non-autenticato');
$router->post('/registrazione', 'app/controllers/autenticazione/registrazione.controller.php')->soloSe('non-autenticato');
$router->post('/admin/login', 'app/controllers/autenticazione/login-admin.controller.php')->soloSe('non-autenticato');
$router->post('/admin/registrazione', 'app/controllers/autenticazione/registrazione-admin.controller.php')->soloSe('non-autenticato');
$router->post('/logout', 'app/controllers/autenticazione/logout.controller.php')->soloSe('autenticato');
$router->post('/home/le-mie-skill/aggiungi', 'app/controllers/skills/non-admin/aggiungi-skill.controller.php')->soloSe('autenticato');
$router->post('/admin/home/gestione-skills/aggiungi', 'app/controllers/skills/admin/aggiungi-skill.controller.php')->soloSe('admin');
$router->post('/home/crea-progetto/informazioni-base', 'app/controllers/creazione-progetto/info-base.controller.php')->soloSe('creatore');
$router->post('/home/crea-progetto/hardware/componenti', 'app/controllers/creazione-progetto/hardware/aggiungi-componente.controller.php')->soloSe('creatore');

//PUT


//DELETE
$router->delete('/rimuovi-skill', 'app/controllers/skills/non-admin/elimina-skill.controller.php')->soloSe('autenticato');
$router->delete('/admin/rimuovi-skill',  'app/controllers/skills/admin/elimina-skill.controller.php')->soloSe('admin');

//PATCH