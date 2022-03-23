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
        'Login-index'               => 0b1, // 0001 = 1
        'Comunidad-index'           => 0b10, // 0010 = 2
        'Comunidad-nueva'           => 0b100,  // 0100 = 4
        'Comunidad-editar'          => 0b1000, // 1000 = 8
        'Comunidad-borrar'          => 0b10000, //10000 = 16
        'Comunidad-actualizarCuota' => 0b100000,
        'Propiedad-comunidad'       => 0b1000000,  // 100000 = 32
        'Propiedad-nueva'           => 0b10000000,// 1000000 = 64
        'Propiedad-editar'          => 0b100000000,
        'Propiedad-borrar'          => 0b1000000000,
        'Cerrar_sesion-index'       => 0b10000000000, 
        'Usuario-index'             => 0b100000000000,
        'Usuario-nuevo'             => 0b1000000000000,
        'Usuario-editar'            => 0b10000000000000,
        'Usuario-borrar'            => 0b100000000000000,
        'Cuota-ver'                 => 0b1000000000000000,
        'Cuota-cambiarEstadoCuota'  => 0b10000000000000000,
        'Cuota-cuotasPendientes'    => 0b100000000000000000,
        'Cuota-crearCuotas'         => 0b1000000000000000000
    );

    $permisos = array(
        ''          => 0b1,
        'ADMIN'     => 0b1111111111111111111, // 15 = 1111 significa que permite la función 1,2,3,4
        'OPERARIO'  => 0b1111111111111111111, // 1101 significa que permite la función 1,2,4
        'USUARIO'   => 0b1111111111111111111   // 1111
    );

    if (!array_key_exists($control, $funciones) || !array_key_exists($tipoUsuario, $permisos)) {
        die('Usted no tiene permisos para acceder a este sitio');
    }

    if (!($funciones[$control] & $permisos[$tipoUsuario])) {
        die('Usted no tiene permisos para acceder a este sitio');
    }
    return true;
}