<?php

//GET
$router->get('/', 'app/index.php');
//autenticazione
$router->get('/home', 'app/views/home/home.view.php')->soloSe('autenticato');
$router->get('/login', 'app/views/autenticazione/login.view.php')->soloSe('non-autenticato');
$router->get('/registrazione', 'app/views/autenticazione/registrazione.view.php')->soloSe('non-autenticato');
$router->get('/admin/login', 'app/views/autenticazione/login.view.php')->soloSe('non-autenticato');
$router->get('/admin/registrazione', 'app/views/autenticazione/registrazione.view.php')->soloSe('non-autenticato');
//progetti
$router->get('/home/progetti', 'app/controllers/progetti/vedi-progetti.controller.php')->soloSe('autenticato');
$router->get('/home/progetti/{nomeProgetto}', 'app/controllers/progetti/info-progetto.controller.php')->soloSe('autenticato');
//profili
$router->get('/home/progetti/{nomeProgetto}/profili', 'app/controllers/profilo/vedi-profili.controller.php')->soloSe('autenticato');
$router->get('/home/progetti/{nomeProgetto}/profili/{nomeProfilo}/skills-richieste', 'app/controllers/profilo/skills-profilo.controller.php')->soloSe('autenticato');
//commenti
$router->get('/home/progetti/{nomeProgetto}/commenta', 'app/views/commenti/inserisci-commento.view.php')->soloSe('autenticato');
$router->get('/home/i-miei-progetti/{nomeProgetto}/commenti/{idCommento}/rispondi', 'app/controllers/commenti/rispondi-commento.controller.php')->soloSe('creatore');
$router->get('/home/progetti/{nomeProgetto}/commenti', 'app/controllers/commenti/visualizza-commenti-progetto.controller.php')->soloSe('autenticato');
//finanziamenti
$router->get('/home/progetti/{nomeProgetto}/finanzia', 'app/controllers/finanziamenti/rewards-disponibili.controller.php')->soloSe('autenticato');
$router->get('/home/i-miei-finanziamenti', 'app/controllers/finanziamenti/ottieni-finanziamenti.controller.php')->soloSe('autenticato');
//skills
$router->get('/home/le-mie-skill', 'app/controllers/skills/non-admin/ottieni-skill.controller.php')->soloSe('autenticato');
$router->get('/admin/home/gestione-skills', 'app/controllers/skills/admin/ottieni-skills.controller.php')->soloSe('admin');
//candidature
$router->get('/home/le-mie-candidature', 'app/controllers/candidature/ottieni-candidature.controller.php')->soloSe('autenticato');
//creazione progetto
$router->get('/home/crea-progetto/informazioni-base', 'app/views/creazione-progetto/crea-progetto.view.php')->soloSe('creatore');
$router->get('/home/crea-progetto/hardware/componenti', 'app/views/creazione-progetto/inserimento-componenti.view.php')->soloSe('creatore');
$router->get('/home/crea-progetto/software/profili', 'app/controllers/creazione-progetto/software/ottieni-skills-disponibili.controller.php')->soloSe('creatore');
$router->get('/home/crea-progetto/foto', 'app/views/creazione-progetto/inserimento-foto-o-rewards.view.php')->soloSe('creatore');
$router->get('/home/crea-progetto/rewards', 'app/views/creazione-progetto/inserimento-foto-o-rewards.view.php')->soloSe('creatore');
$router->get('/home/crea-progetto/conferma-dati', 'app/views/creazione-progetto/conferma-dati.view.php')->soloSe('creatore');
//statistiche
$router->get('/home/statistiche','app/controllers/statistiche/vedi-statistiche.controller.php')->soloSe('autenticato');
//i miei progetti
$router->get('/home/i-miei-progetti', 'app/controllers/progetti/vedi-progetti.controller.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}', 'app/controllers/progetti/info-progetto.controller.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}/profili', 'app/controllers/profilo/vedi-profili.controller.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}/profili/{nomeProfilo}/skills-richieste', 'app/controllers/profilo/skills-profilo.controller.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}/commenta', 'app/views/commenti/inserisci-commento.view.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}/finanzia', 'app/controllers/finanziamenti/rewards-disponibili.controller.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}/aggiungi-profilo', 'app/controllers/creazione-progetto/software/ottieni-skills-disponibili.controller.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}/profili/{nomeProfilo}/candidature', 'app/controllers/profilo/ottieni-candidature.controller.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}/profili/{nomeProfilo}/candidature/{idCandidatura}', 'app/controllers/profilo/ottieni-candidatura.controller.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}/commenti', 'app/controllers/commenti/visualizza-commenti-progetto.controller.php')->soloSe('autenticato');
$router->get('/home/i-miei-progetti/{nomeProgetto}/aggiungi-componente', 'app/views//creazione-progetto/inserimento-componenti.view.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}/aggiungi-reward', 'app/views/creazione-progetto/inserimento-foto-o-rewards.view.php')->soloSe('creatore');
$router->get('/home/i-miei-progetti/{nomeProgetto}/aggiungi-foto', 'app/views/creazione-progetto/inserimento-foto-o-rewards.view.php')->soloSe('creatore');

//POST

//autenticazione
$router->post('/login', 'app/controllers/autenticazione/login.controller.php')->soloSe('non-autenticato');
$router->post('/registrazione', 'app/controllers/autenticazione/registrazione.controller.php')->soloSe('non-autenticato');
$router->post('/admin/login', 'app/controllers/autenticazione/login-admin.controller.php')->soloSe('non-autenticato');
$router->post('/admin/registrazione', 'app/controllers/autenticazione/registrazione-admin.controller.php')->soloSe('non-autenticato');
$router->post('/logout', 'app/controllers/autenticazione/logout.controller.php')->soloSe('autenticato');
// skills
$router->post('/home/le-mie-skill', 'app/controllers/skills/non-admin/aggiungi-skill.controller.php')->soloSe('autenticato');
$router->post('/admin/home/gestione-skills', 'app/controllers/skills/admin/aggiungi-skill.controller.php')->soloSe('admin');
// creazione progetto
$router->post('/home/crea-progetto/informazioni-base', 'app/controllers/creazione-progetto/info-base.controller.php')->soloSe('creatore');
$router->post('/home/crea-progetto/hardware/componenti', 'app/controllers/creazione-progetto/hardware/aggiungi-componente.controller.php')->soloSe('creatore');
$router->post('/home/crea-progetto/software/profili', 'app/controllers/creazione-progetto/software/aggiungi-profilo.controller.php')->soloSe('creatore');
$router->post('/home/crea-progetto/software/profili/skills', 'app/controllers/creazione-progetto/software/aggiungi-skill-richieste.controller.php')->soloSe('creatore');
$router->post('/home/crea-progetto/foto', 'app/controllers/creazione-progetto/inserisci-foto.controller.php')->soloSe('creatore');
$router->post('/home/crea-progetto/rewards', 'app/controllers/creazione-progetto/inserimento-reward.controller.php')->soloSe('creatore');
$router->post('/home/crea-progetto/conferma-dati', 'app/controllers/creazione-progetto/creazione-progetto.controller.php')->soloSe('creatore');
//profili
$router->post('/home/progetti/{nomeProgetto}/profili/{nomeProfilo}/candidature', 'app/controllers/profilo/invio-candidatura.controller.php')->soloSe('autenticato');
$router->post('/home/i-miei-progetti/{nomeProgetto}/profili', 'app/controllers/i-miei-progetti/inserimento-profilo.controller.php')->soloSe('creatore');
$router->post('/home/i-miei-progetti/{nomeProgetto}/componenti', 'app/controllers/i-miei-progetti/inserimento-componente.controller.php')->soloSe('creatore');
$router->post('/home/i-miei-progetti/{nomeProgetto}/rewards', 'app/controllers/i-miei-progetti/inserimento-reward.controller.php')->soloSe('creatore');
$router->post('/home/i-miei-progetti/{nomeProgetto}/foto', 'app/controllers/i-miei-progetti/inserimento-foto.controller.php')->soloSe('creatore');
//commenti
$router->post('/home/i-miei-progetti/{nomeProgetto}/commenti/{idCommento}/rispondi', 'app/controllers/commenti/invia-risposta.controller.php')->soloSe('creatore');
$router->post('/home/progetti/{nomeProgetto}/commenti', 'app/controllers/commenti/inserisci-commento.controller.php')->soloSe('autenticato');
//finanziamenti
$router->post('/home/progetti/{nomeProgetto}/finanziamenti', 'app/controllers/finanziamenti/inserisci-finanziamento.controller.php')->soloSe('autenticato');


//PUT


//DELETE
$router->delete('/home/le-mie-skill/{nomeSkill}', 'app/controllers/skills/non-admin/elimina-skill.controller.php')->soloSe('autenticato');
$router->delete('/admin/home/gestione-skills/{nomeSkill}',  'app/controllers/skills/admin/elimina-skill.controller.php')->soloSe('admin');
$router->delete('/home/crea-progetto/software/profili/skills/{nomeSkill}', 'app/controllers/creazione-progetto/software/elimina-skill-richiesta.controller.php')->soloSe('creatore');
$router->delete('/home/crea-progetto/annulla', 'app/controllers/creazione-progetto/elimina-dati.controller.php')->soloSe('creatore');

//PATCH
$router->patch('/home/i-miei-progetti/{nomeProgetto}/profili/{nomeProfilo}/candidature/{idCandidatura}', 'app/controllers/profilo/gestione-candidatura.controller.php')->soloSe('creatore');
