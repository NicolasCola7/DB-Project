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
$router->get('/home/le-mie-skill', 'app/controllers/skills/non-admin/ottieni-skill.controller.php')->soloSe('autenticato');
$router->get('/admin/home/gestione-skills', 'app/controllers/skills/admin/ottieni-skills.controller.php')->soloSe('admin');
$router->get('/home/info-progetto/profili', 'app/views/profilo/view-profili.view.php')->soloSe('autenticato');
$router->get('/home/info-progetto/profili-controller', 'app/controllers/profilo/view-profili.controller.php')->soloSe('autenticato');
$router->get('/home/info-progetto/profilo', 'app/views/profilo/view-dettagli-profilo.view.php')->soloSe('autenticato');
$router->get('/home/info-progetto/profilo-controller', 'app/controllers/profilo/view-dettagli-profilo.controller.php')->soloSe('autenticato');
$router->get('/home/info-progetto/profilo/candidature', 'app/views/profilo/view-candidature-profilo.view.php')->soloSe('autenticato');
$router->get('/home/info-progetto/profilo/candidature-controller', 'app/controllers/profilo/view-candidature-profilo.controller.php')->soloSe('autenticato');
$router->get('/home/info-progetto/profilo/check-candidatura', 'app/views/profilo/check-candidatura-profilo.view.php')->soloSe('autenticato');
$router->get('/home/info-progetto/profilo/check-candidatura-controller', 'app/controllers/profilo/check-candidatura-profilo.controller.php')->soloSe('autenticato');
$router->get('/home/crea-progetto/informazioni-base', 'app/views/creazione-progetto/crea-progetto.view.php')->soloSe('creatore');
$router->get('/home/crea-progetto/hardware/componenti', 'app/views/creazione-progetto/inserimento-componenti.view.php')->soloSe('creatore');
$router->get('/home/crea-progetto/software/profili', 'app/controllers/creazione-progetto/software/ottieni-skills-disponibili.controller.php')->soloSe('creatore');
$router->get('/home/crea-progetto/software/profili/skills', 'app/controllers/creazione-progetto/software/ottieni-skills-disponibili.controller.php')->soloSe('creatore');
$router->get('/home/crea-progetto/foto', 'app/views/creazione-progetto/inserimento-foto.view.php')->soloSe('creatore');
$router->get('/home/visualizzaStatistiche','app/views/statistiche/visualizzaStatistiche.view.php')->soloSe('autenticato');
$router->get('/ottieni-statistiche', 'app/controllers/statistiche/visualizzaStatistiche.controller.php')->soloSe('autenticato');
$router->get('/home/crea-progetto/rewards', 'app/views/creazione-progetto/inserimento-rewards.view.php')->soloSe('creatore');
$router->get('/home/crea-progetto/conferma-dati', 'app/views/creazione-progetto/conferma-dati.view.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti', 'app/controllers/i-miei-progetti/i-miei-progetti.controller.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}/informazioni', 'app/controllers/i-miei-progetti/info-progetto.controller.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}/profili', 'app/controllers/i-miei-progetti/vedi-profili.controller.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}/profili/{nomeProfilo}/skills-richieste', 'app/controllers/i-miei-progetti/skills-profilo.controller.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}/profili/{nomeProfilo}/candidature', 'app/controllers/i-miei-progetti/candidature-profilo.controller.php')->soloSe('creatore');
$router->get('/home/progetti/{nomeProgetto}/commenti', 'app/views/commenti/inserisci-commento.view.php')->soloSe('autenticato');
$router->get('/home/progetti/{nomeProgetto}/finanziamenti', 'app/controllers/finanziamenti/rewards-disponibili.controller.php')->soloSe('autenticato');

//POST
$router->post('/login', 'app/controllers/autenticazione/login.controller.php')->soloSe('non-autenticato');
$router->post('/registrazione', 'app/controllers/autenticazione/registrazione.controller.php')->soloSe('non-autenticato');
$router->post('/admin/login', 'app/controllers/autenticazione/login-admin.controller.php')->soloSe('non-autenticato');
$router->post('/admin/registrazione', 'app/controllers/autenticazione/registrazione-admin.controller.php')->soloSe('non-autenticato');
$router->post('/logout', 'app/controllers/autenticazione/logout.controller.php')->soloSe('autenticato');
$router->post('/home/le-mie-skill', 'app/controllers/skills/non-admin/aggiungi-skill.controller.php')->soloSe('autenticato');
$router->post('/admin/home/gestione-skills', 'app/controllers/skills/admin/aggiungi-skill.controller.php')->soloSe('admin');
$router->post('/home/crea-progetto/informazioni-base', 'app/controllers/creazione-progetto/info-base.controller.php')->soloSe('creatore');
$router->post('/home/crea-progetto/hardware/componenti', 'app/controllers/creazione-progetto/hardware/aggiungi-componente.controller.php')->soloSe('creatore');
$router->post('/home/crea-progetto/software/profili', 'app/controllers/creazione-progetto/software/aggiungi-profilo.controller.php')->soloSe('creatore');
$router->post('/home/crea-progetto/software/profili/skills', 'app/controllers/creazione-progetto/software/aggiungi-skill-richieste.controller.php')->soloSe('creatore');
$router->post('/home/info-progetto/profilo-invio-candidatura', 'app/controllers/profilo/post-candidatura-prog.controller.php')->soloSe('autenticato');
$router->post('/home/info-progetto/profilo/check-candidatura/esito', 'app/controllers/profilo/validate-candidatura-profilo.controller.php')->soloSe('autenticato');
$router->post('/home/crea-progetto/foto', 'app/controllers/creazione-progetto/inserisci-foto.controller.php')->soloSe('creatore');
$router->post('/home/crea-progetto/rewards', 'app/controllers/creazione-progetto/inserimento-reward.controller.php')->soloSe('creatore');
$router->post('/home/crea-progetto/conferma-dati', 'app/controllers/creazione-progetto/creazione-progetto.controller.php')->soloSe('creatore');
$router->post('/home/progetti/{nomeProgetto}/commenti', 'app/controllers/commenti/inserisci-commento.controller.php')->soloSe('autenticato');
$router->post('/home/progetti/{nomeProgetto}/finanziamenti', 'app/controllers/finanziamenti/inserisci-finanziamento.controller.php')->soloSe('autenticato');

//PUT


//DELETE
$router->delete('/home/le-mie-skill/{nomeSkill}', 'app/controllers/skills/non-admin/elimina-skill.controller.php')->soloSe('autenticato');
$router->delete('/admin/home/gestione-skills/{nomeSkill}',  'app/controllers/skills/admin/elimina-skill.controller.php')->soloSe('admin');
$router->delete('/home/crea-progetto/software/profili/skills/{nomeSkill}', 'app/controllers/creazione-progetto/software/elimina-skill-richiesta.controller.php')->soloSe('creatore');
$router->delete('/home/crea-progetto/annulla', 'app/controllers/creazione-progetto/elimina-dati.controller.php')->soloSe('creatore');
//PATCH