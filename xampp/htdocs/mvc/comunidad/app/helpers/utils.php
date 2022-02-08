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

function auth(string $control, string $usuario) {
    /* ---------------------------------------------
     * Funciones
     * ---------
     * comunidad-index = 1
     * comunidad-ver = 2
     * 
     * propiedades-comunidad = 3
     * propiedades-cuota = 4
     * 
     * ...
     * **************************** */
    $funciones = array(
        'comunidad' => 1, // 0001
        'comunidad-ver' => 2, // 0010
        'propiedades-comunidad' => 4, // 0100
        'propiedades-cuota' => 15      // 1000        
    );

    $permisos = array(
        'invitado' => 15, // 15 = 1111 significa que permite la función 1,2,3,4
        'usuario' => 15, // 1101 significa que permite la función 1,2,4
        'admin' => 15   // 1111
    );

    if (!array_key_exists($control, $funciones) || !array_key_exists($usuario, $permisos)) {
        die('Usted no tiene permisos para acceder a este sitio');
    }

    if (!($funciones[$control] & $permisos[$usuario])) {
        die('Usted no tiene permisos para acceder a este sitio');
    }
    return true;
}
