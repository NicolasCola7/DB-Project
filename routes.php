<?php

$router->get('/', 'public/index.php');


$router->post('/login', 'controllers/autenticazione/login.controller.php');