<?php

//GET
$router->get('/', 'app/index.php');
$router->get('/home', 'app/controllers/home.controller.php');
$router->get('/login', 'app/views/autenticazione/login.view.php');

//POST
$router->post('/login', 'app/controllers/autenticazione/login.controller.php');


//PUT


//DELETE


//PATCH