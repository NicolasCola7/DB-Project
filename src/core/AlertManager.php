<?php
namespace core;

class AlertManager
{
    public static function setSuccess($msg)
    {
        $_SESSION['successo'] = $msg;
    }

    public static function setWarning($msg)
    {
        $_SESSION['avviso'] = $msg;
    }

    public static function setError($msg)
    {
        $_SESSION['errore'] = $msg;
    }

    public static function show($errori = [])
    {
        if (!empty($errori)) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    let messaggi = '';";
            foreach ($errori as $msg) {
                echo "messaggi += '" . addslashes($msg) . "\\n';";
            }
            echo "Swal.fire({
                        title: 'Errore!',
                        text: messaggi.trim(),
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
        }

        if (isset($_SESSION['successo'])) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        title: 'Successo!',
                        text: '" . addslashes($_SESSION['successo']) . "',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
            unset($_SESSION['successo']);
        }

        if (isset($_SESSION['avviso'])) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        title: 'Attenzione!',
                        text: '" . addslashes($_SESSION['avviso']) . "',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
            unset($_SESSION['avviso']);
        }

        if (isset($_SESSION['errore'])) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        title: 'Errore!',
                        text: '" . addslashes($_SESSION['errore']) . "',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
            unset($_SESSION['errore']);
        }
    }
}
