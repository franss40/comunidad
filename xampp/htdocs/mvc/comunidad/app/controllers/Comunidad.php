<?php

/**
 * Comunidad
 *
 * @author Fran
 */
class Comunidad extends Controller {

    public function __construct() {
        $this->addModel('Comunidad_model');
    }

    public function index() {
        $comunidades = $this->models['Comunidad_model']->getComunidades();
        $total = $this->models['Comunidad_model']->getTotal();

        $cuotasPendientes = $this->models['Comunidad_model']->getComuConCuotasPtes();

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
        $comunidad = $this->models->getComunidad($cod);

        $data = ['comunidad' => $comunidad];

        $this->render('comunidad/ver', $data);
    }

}
