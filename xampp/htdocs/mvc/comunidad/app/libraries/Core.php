<?php

/**
 * Clase principal donde se controlan todas las peticiones
 * Formateo URL:  /controlador/método/parámetros
 */
class Core {

    protected $controladorActual = DEFAULT_CONTROLLER;   // Default
    protected $metodoActual = 'index';
    protected $parametros = [];
    protected $acceso = '';

    public function __construct() {

        $url = $this->getUrl();

        //ucwords convierte a mayúsculas el primer carácter
        if ($url && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->controladorActual = ucwords($url[0]);
            $this->acceso = $url[0];
            unset($url[0]);
        }
        require_once '../app/controllers/' . $this->controladorActual . '.php';
        $this->controladorActual = new $this->controladorActual();

        // Revisamos el 2º parámetro, que representa el método
        if (isset($url[1])) {
            if (method_exists($this->controladorActual, $url[1])) {
                $this->metodoActual = $url[1];
                $this->acceso .= '-' . $url[1];
                unset($url[1]);
            } else {
                die('El controlador no existe - 404 not found');
            }
        }

        $this->parametros = $url ? array_values($url) : [];

        /* ----------------------
         * Llama a la función 'método actúal' de la clase controlador con los 
         * parámetros. Esos parámetros no lo pasa como un array como pudiera 
         * suponerse, sino como parámetros normales. 
         * Así si la función destino tiene un sólo parámetro de recepción y 
         * la url tiene 2, sólo capta el primer parámetro sin dar error.
         * ***************************************************************** */
        /* ----------------------------------------
         * Antes de llamar al controlador y método con sus parámetros vamos a ver 
         * Si el usuario está autentificado y autorizado         
         * ************************************************************** */
        auth($this->acceso, 'invitado');

        call_user_func_array([$this->controladorActual, $this->metodoActual],
                $this->parametros);
    }

    # Captamos los parámetros de la url actúal y los devolvemos.

    private function getUrl() {
        $url = filter_input(INPUT_GET, 'url');

        if (isset($url)) {
            // Elimino las barras del final, limpio los datos y creo el array
            return explode('/', strip_tags(rtrim($url, '/')));
        } else {
            $url[0] = $this->controladorActual;
            return $url;
        }
    }

}
