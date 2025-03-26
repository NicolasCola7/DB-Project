<?php
namespace core;

class AlertManager {
    
    public static function setSuccess($msg) {
        $_SESSION['successo'] = $msg;
    }

    public static function setWarning($msg) {
        $_SESSION['avviso'] = $msg;
    }

    public static function setError($chiave, $msg) {
        $_SESSION['errore'][$chiave] = $msg;
    }

    public static function show() {
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
            foreach($_SESSION['errore'] as $chiave => $errore) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            title: 'Errore!',
                            text: '" . addslashes($errore) . "',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                </script>";
                unset($_SESSION['errore'][$chiave]);
            }
            unset($_SESSION['errore']);
        }
    }
}
