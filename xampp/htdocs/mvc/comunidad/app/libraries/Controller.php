<?php

/**
 * Controlador base
 *      Permite cargar distintos modelos y cargar las correspondientes vistas
 *
 * @author Fran
 */
class Controller {

    protected $model;

    public function addModel($model) {
        require_once APPROOT . '/models/' . $model . '.php';
        $this->model[$model] = new $model();
    }

    public function render($view, $data = []) {
        if (file_exists('../app/views/' . $view . '.php')) {
            if (is_array($data) || empty($data)) {
                foreach ($data as $key => $value) {
                    $$key = $value;
                }
            }
            require_once '../app/views/' . $view . '.php';
        } else {
            die('La vista no existe');
        }
    }

}
