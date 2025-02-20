<?php

//GET
$router->get('/', 'app/index.php');
$router->get('/home', 'app/views/home/home.view.php')->soloSe('autenticato');
$router->get('/homeController', 'app/controllers/home/home.controller.php')->soloSe('autenticato');
$router->get('/login', 'app/views/autenticazione/login.view.php')->soloSe('non-autenticato');
$router->get('/registrazione', 'app/views/autenticazione/registrazione.view.php')->soloSe('non-autenticato');
$router->get('/admin/login', 'app/views/autenticazione/login-admin.view.php')->soloSe('non-autenticato');
$router->get('/admin/registrazione', 'app/views/autenticazione/registrazione-admin.view.php')->soloSe('non-autenticato');
$router->get('/home/visualizzaProgettiController','app/controllers/home/homeViewProgetti.controller.php')->soloSe('autenticato');
$router->get('/home/visualizzaProgetti','app/views/home/homeViewProgetti.view.php')->soloSe('autenticato');
$router->get('/home/le-mie-skill', 'app/views/skills/le-mie-skill.view.php')->soloSe('autenticato');


//POST
$router->post('/login', 'app/controllers/autenticazione/login.controller.php')->soloSe('non-autenticato');
$router->post('/registrazione', 'app/controllers/autenticazione/registrazione.controller.php')->soloSe('non-autenticato');
$router->post('/admin/login', 'app/controllers/autenticazione/login-admin.controller.php')->soloSe('non-autenticato');
$router->post('/admin/registrazione', 'app/controllers/autenticazione/registrazione-admin.controller.php')->soloSe('non-autenticato');
$router->post('/logout', 'app/controllers/autenticazione/logout.controller.php')->soloSe('autenticato');
//PUT


//DELETE


//PATCH