<?php

/**
 * Gestión de datos de las comunidades
 *
 * @author Fran
 */
class Comunidad extends Controller {

    public function __construct() {
        $this->setModel('Comunidades');
    }
    
    /**
     * Muestra las comunidades que existen con sus cuotas pendientes
     *  
     */
    public function index() {
        $comunidades = $this->model->getComunidades();
        $total = $this->model->getTotal();

        $cuotasPendientes = $this->model->getComuConCuotasPtes();
        foreach ($comunidades as $comunidad) {
            $comunidad->cuantos = 0;
            $comunidad->suma = 0;
            foreach ($cuotasPendientes as $cuotaPendiente) {
                if ($comunidad->nombre == $cuotaPendiente->nombre) {
                    $comunidad->cuantos = $cuotaPendiente->cuantos;
                    $comunidad->suma = $cuotaPendiente->suma;
                }
            }
        }

        $data = ['comunidades' => $comunidades, 'total' => $total];

        $this->render('comunidad/index', $data);
    }

    /**
     * Obtiene la información de una determinada comunidad por su cod.
     * 
     * @param int $cod
     */
    public function ver(int $cod) {
        $comunidad = $this->model->getComunidad($cod);

        $data = ['comunidad' => $comunidad];

        $this->render('comunidad/ver', $data);
    }

}
