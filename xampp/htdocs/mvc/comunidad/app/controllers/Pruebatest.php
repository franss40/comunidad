<?php

/**
 * Prueba los distintos módulos
 *
 * @author Fco Sanz
 */
class Pruebatest extends Controller{    
    /**
     * Aquí hacemos los test de todos los casos de uso (CU); uno por uno
     */
    public function index() {
        require_once APPROOT.'/controllers/'.'PruebatestComunidad.php';
        //Compruebo los casos de uso del módulo Comunidad
        new PruebatestComunidad();
        echo '<hr>';
        require_once APPROOT.'/controllers/'.'PruebatestUsuario.php';
        //Compruebo los casos de uso del módulo Usuario
        new PruebatestUsuario();
        echo '<hr>';
        //Compruebo los casos de uso del módulo Propiedades
        require_once APPROOT.'/controllers/'.'PruebatestPropiedad.php';
        new PruebatestPropiedad();
        echo '<hr>';
        //Compruebo los casos de uso del módulo Cuotas
        require_once APPROOT.'/controllers/'.'PruebatestCuota.php';
        new PruebatestCuota();
        echo '<hr>';
        //Compruebo los casos de uso del módulo Login
        require_once APPROOT.'/controllers/'.'PruebatestLogin.php';
        new PruebatestLogin();
    }
}
