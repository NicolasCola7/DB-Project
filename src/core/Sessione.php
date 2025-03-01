<?php

namespace Core;

class Sessione {
    
    public static function contains($chiave) {
        return (bool) static::get($chiave);
    }

    public static function put($chiave, $valore) {
        $_SESSION[$chiave] = $valore;
    }

    public static function get($chiave, $default = null) {
        return $_SESSION['_flash'][$chiave] ?? $_SESSION[$chiave] ?? $default;
    }

    public static function flash($chiave, $valore) {
        $_SESSION['_flash'][$chiave] = $valore;
    }

    public static function unflash() {
       unset($_SESSION['_flash']);
    }

    public static function flush() {
        $_SESSION = [];
    }

    public static function destroy() {
        static::flush();

        session_destroy();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
}