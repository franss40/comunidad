<?php
/**
 * Función para autorizar la entrada a un usuario registrado a un determinado
 * sitio
 * 
 * @param string $control
 * @param string $tipoUsuario
 * @return boolean
 */
function auth(string $control, string $tipoUsuario = '') {
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
        'Comunidad-nueva' =>3,  // 0100
        'Comunidad-editar' =>4, // 1000
        'Comunidad-borrar' => 5, //10000
        'Propiedad-comunidad' => 6  // 100000
    );

    $permisos = array(
        '' => 1,
        'ADMIN' => 0b111111, // 15 = 1111 significa que permite la función 1,2,3,4
        'OPERARIO' => 0b111111, // 1101 significa que permite la función 1,2,4
        'USUARIO' => 0b111111   // 1111
    );

    if (!array_key_exists($control, $funciones) || !array_key_exists($tipoUsuario, $permisos)) {
        die('Usted no tiene permisos para acceder a este sitio');
    }

    if (!($funciones[$control] & $permisos[$tipoUsuario])) {
        die('Usted no tiene permisos para acceder a este sitio');
    }
    return true;
}