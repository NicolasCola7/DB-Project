<?

// Controlla se l'utente è loggatp, se si lo redirige alla home, altrimenti al login
if (!isset($_SESSION['utente'])) {
    header("location: /login");
} else {
    header("location: /home");
}