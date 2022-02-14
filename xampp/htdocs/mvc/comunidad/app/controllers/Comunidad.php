<?php

/**
 * Comunidad
 *
 * @author Fran
 */
class Comunidad extends Controller {

    public function __construct() {
        $this->setModel('Comunidades');
    }

    public function index() {
        $comunidades = $this->model->getComunidades();
        $total = $this->model->getTotal();

        $cuotasPendientes = $this->model->getComuConCuotasPtes();

        foreach ($comunidades as $comunidad) {
            $comunidad->cuantos = 0;
            $comunidad->suma = 0;

            if ($comunidad->nombre == $cuotasPendientes[0]->nombre) {
                $comunidad->cuantos = $cuotasPendientes[0]->cuantos;
                $comunidad->suma = $cuotasPendientes[0]->suma;
            }
        }

        $data = ['comunidades' => $comunidades,
            'total' => $total];

        $this->render('comunidad/index', $data);
    }

    public function ver(int $cod) {
        $comunidad = $this->model->getComunidad($cod);

        $data = ['comunidad' => $comunidad];

        $this->render('comunidad/ver', $data);
    }

}
