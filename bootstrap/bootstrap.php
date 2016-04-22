<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/22/16
 */
try {
    $dotenv = new Dotenv\Dotenv(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);
    $dotenv->load();
    $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD'])->notEmpty();
} catch (Exception $e) {
// catch exception -- means it's on production no env.
}

if (php_sapi_name() !== 'cli') {

    session_start();

    $_SESSION['CURRENT_URL'] = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

    if (getenv('APP_ENV') !== 'heroku') {
        if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
            $redirect = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '.$redirect);
        }
    } else {
        if ((empty($_SERVER['HTTP_X_FORWARDED_PROTO']) || $_SERVER['HTTP_X_FORWARDED_PROTO'] !== 'https')
            && (empty($_SERVER['HTTP_X_FORWARDED_SSL']) || $_SERVER['HTTP_X_FORWARDED_SSL'] === 'off')
        ) {
            $redirect = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '.$redirect);
        }
    }
}