<?
if (!isset($_SESSION['utente'])) {
    header("location: /login");
} else {
    header("location: /home");
}