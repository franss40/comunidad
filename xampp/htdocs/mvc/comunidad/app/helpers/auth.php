<?php
/**
 * Función para autorizar la entrada a un usuario registrado a un determinado
 * sitio mediante la función pasada como control y el tipo de usuario
 * El máximo permitido son 64 bits - depende del sistema operativo
 * Tipos usuarios:
 * admin: Tendrán control total para todas las funciones
 * operario: Tendrán acceso a todo excepto al módulo de usuarios
 * usuario: Solo tiene acceso a los listados y a las cuotas pendientes
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
     * comunidad-nueva = 4
     * 
     * **************************** */

    $funciones = array(
        'Login-index'               => 0b1, // 0001 = 1
        'Comunidad-index'           => 0b10, // 0010 = 2
        'Comunidad-nueva'           => 0b100,  // 0100 = 4
        'Comunidad-editar'          => 0b1000, // 1000 = 8
        'Comunidad-borrar'          => 0b10000, //10000 = 16
        'Comunidad-actualizarCuota' => 0b100000,
        'Propiedad-comunidad'       => 0b1000000,
        'Propiedad-nueva'           => 0b10000000,
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
    
    // En el caso de operario/usuario (no hago de momento distinción)
    // contando por la derecha, el 1 significa que tiene permiso para el login
    // el siguiente para la comunidad-index, y así sucesivamente
    // Los permisos de Login-index y Cerrar_sesion-index lo tendrán todos activos.
    $permisos = array(
        ''          => 0b1,
        'ADMIN'     => 0b1111111111111111111, // Todo 1 significa que tiene permisos totales
        'OPERARIO'  => 0b1111000011111111111, // 1101 significa que permite la función 1,2,4
        'USUARIO'   => 0b0101000010001000011   // 1111
    );

    // Si no existe la función o el tipo de usuario salimos
    if (!array_key_exists($control, $funciones) || !array_key_exists($tipoUsuario, $permisos)) {
        die('Usted no tiene permisos para acceder a este sitio');
    }
    
    //Aquí comprobamos con un and lógico si tenemos permisos o no
    if (!($funciones[$control] & $permisos[$tipoUsuario])) {
        die('Usted no tiene permisos para acceder a este sitio');
    }
    return true;
}