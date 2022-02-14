<?php

declare(strict_types=1);

session_start();

/**
 * Clase principal donde se controlan todas las peticiones
 * Formateo URL:  /controlador/método/parámetros
 * El acceso se utiliza para la autorización de los usuarios
 * 
 */
class Core {

    protected $controladorActual = DEFAULT_CONTROLLER;   // Default
    protected $metodoActual = 'index';
    protected $parametros = [];
    protected $acceso = '';

    public function __construct() {

        $url = $this->getUrl();

        # Revisamos el primer parámetro
        $this->getControlador($url);

        require_once '../app/controllers/' . $this->controladorActual . '.php';
        $this->controladorActual = new $this->controladorActual();

        // Revisamos el 2º parámetro, que representa el método
        $this->getMetodo($url);

        $this->parametros = $url ? array_values($url) : [];

        /*********************************
         * Vemos en cada petición si el usuario está autorizado         
         * ************************************************************** */
        isset($_SESSION['user']) ? auth($this->acceso, $_SESSION['tipo']) : auth($this->acceso);

        /* ----------------------
         * Llama a la función 'método actúal' de la clase controlador con los 
         * parámetros. Esos parámetros no lo pasa como un array como pudiera 
         * suponerse, sino como parámetros normales. 
         * Así si la función destino tiene un sólo parámetro de recepción y 
         * la url tiene 2, sólo capta el primer parámetro sin dar error.
         * **************************************************************** */
        call_user_func_array([$this->controladorActual, $this->metodoActual],
                $this->parametros);
    }

    /**
     * Obtener el controlador de la url
     * 
     * @param array $url
     */
    private function getControlador(&$url) {
        if ($url && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->controladorActual = ucwords($url[0]);
            unset($url[0]);
        } elseif ($url && !file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            die('Controlador no existe - 404 not found!');
        }
        $this->acceso = $this->controladorActual;
    }

    /**
     * obtener el método de la url
     * 
     * @param array $url
     */
    private function getMetodo(&$url) {
        if (isset($url[1])) {
            if (method_exists($this->controladorActual, $url[1])) {
                $this->metodoActual = $url[1];
                unset($url[1]);
            } else {
                die('No existe ese método en el controlador - 404 not found');
            }
        }
        $this->acceso .= '-' . $this->metodoActual;
    }

    /**
     * Obtener la url y dividirla en controlador, método y parámetros en su caso
     * 
     * @return array
     */
    private function getUrl() {
        $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
        if (isset($url)) {
            // Elimino las barras del final, limpio los datos y creo el array
            return explode('/', strip_tags(rtrim($url, '/')));
        } else {
            $url[0] = $this->controladorActual;
            return $url;
        }
    }

}
