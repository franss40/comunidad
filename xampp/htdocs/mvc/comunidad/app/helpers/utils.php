<?php

function redirect($pagina) {
    header('location:' . URLROOT . '/' . $pagina);
}

function salvaHtml($variable) {
    return htmlentities($variable, ENT_NOQUOTES, "UTF-8");
}

function urlAmigable($url) {
    return str_replace(' ', '-', $url);
}

function auth(string $control, string $usuario = '') {
    /* ---------------------------------------------
     * Funciones
     * ---------
     * login-index = 1
     * comunidad-index = 2
     * comunidad-ver = 3
     * 
     * propiedades-comunidad = 4
     * propiedades-cuota = 5
     * 
     * 
     * **************************** */
    $funciones = array(
        'Login-index' => 1, // 0001
        'Comunidad-index' => 2, // 0010
        'Propiedad-comunidad' => 4
    );

    $permisos = array(
        '' => 1,
        'ADMIN' => 15, // 15 = 1111 significa que permite la función 1,2,3,4
        'OPERARIO' => 15, // 1101 significa que permite la función 1,2,4
        'USUARIO' => 15   // 1111
    );

    if (!array_key_exists($control, $funciones) || !array_key_exists($usuario, $permisos)) {
        die('Usted no tiene permisos para acceder a este sitio');
    }

    if (!($funciones[$control] & $permisos[$usuario])) {
        die('Usted no tiene permisos para acceder a este sitio');
    }
    return true;
}
