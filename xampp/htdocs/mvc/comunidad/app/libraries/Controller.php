<?php

/**
 * Controlador base
 *      Permite cargar distintos modelos y cargar las correspondientes vistas
 *
 * @author Fran
 */
class Controller {

    protected $models;
    protected $model;

    /**
     * Añado un array de modelos
     * 
     * @param string $model
     */
    public function addModel($model) {
        require_once APPROOT . '/models/' . $model . '.php';
        $this->models[$model] = new $model();
    }

    /**
     * Añado un determinado modelo
     * 
     * @param String $model
     */
    public function setModel($model) {
        require_once APPROOT . '/models/' . $model . '.php';
        $this->model = new $model();
    }

    /**
     * Renderizo una vista con los datos que nos indican
     * 
     * @param string $view
     * @param array $data
     */
    public function render($view, $data = []) {
        if (file_exists('../app/views/' . $view . '.php')) {
            foreach ($data as $key => $value) {
                $$key = $value;
            }
            require_once '../app/views/' . $view . '.php';
        } else {
            die('La vista no existe');
        }
    }

}
