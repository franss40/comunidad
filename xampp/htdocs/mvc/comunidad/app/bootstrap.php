<?php

/* * ----------------------
 * El Core capta los datos de la url, e inicializa la clase del controlador(new),
 * que sería el primer parámetro pasado. 
 * La url sigue esta terminología : /controlador/método/parámetros/
 * En caso de que no exista cargaremos uno x defecto.
  ------------------------------------------------------------------------------ */

require_once 'config/config.php';

switch (ENVIRONMENT) {
    case 'development':
        ini_set('display_errors', 1); //Activo los errores por pantalla
        error_reporting(-1);         //Activo todos los errores posibles = E_ALL
        break;
    case 'production':
        ini_set('display_errors', 0);
        error_reporting(E_ALL &
                ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE &
                ~E_USER_DEPRECATED);
        break;
    case 'testing':
        ini_set('display_errors', 1);
        error_reporting(-1);
        break;
    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'El entorno no está configurado correctamente';
        exit(1);
}

spl_autoload_register(function ($className) {
    require_once 'libraries/' . $className . '.php';
});

// Cargo los helpers
require_once 'helpers/utils.php';
require_once 'helpers/auth.php';

// cargo el Core para reiniciar todo
new Core();
