<?php

//GET
$router->get('/', 'app/index.php');
$router->get('/home', 'app/controllers/home.controller.php');
$router->get('/login', 'app/views/autenticazione/login.view.php');
$router->get('/registrazione', 'app/views/autenticazione/registrazione.view.php');
$router->get('/admin/login', 'app/views/autenticazione/login-admin.view.php');
$router->get('/admin/registrazione', 'app/views/autenticazione/registrazione-admin.view.php');

//POST
$router->post('/login', 'app/controllers/autenticazione/login.controller.php');
$router->post('/registrazione', 'app/controllers/autenticazione/registrazione.controller.php');
$router->post('/admin/login', 'app/controllers/autenticazione/login-admin.controller.php');
$router->post('/admin/registrazione', 'app/controllers/autenticazione/registrazione-admin.controller.php');

//PUT


//DELETE


//PATCH