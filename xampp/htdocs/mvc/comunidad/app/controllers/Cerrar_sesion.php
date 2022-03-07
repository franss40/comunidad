<?php
/**
 * Cerrar Sesión
 *
 * @author Fco Sanz
 */
class Cerrar_sesion extends Controller{

    /**
     * Cerramos sesión y redirigimos al login
     */
    public function index() {
        session_destroy();
        redirect('login');
    }
}
