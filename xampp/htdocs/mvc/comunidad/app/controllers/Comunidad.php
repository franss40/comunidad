<?php

/**
 * Gestión de datos de las comunidades
 *
 * @author Fran
 */
class Comunidad extends Controller {

    public function __construct() {
        $this->setModel('Comunidades');
        $this->addModel('Incidencias');
    }
    
    /**
     * Muestra las comunidades que existen con sus cuotas pendientes
     *  
     */
    public function index() {
        $incidencias = $this->models['Incidencias']->getIncidencias();
        
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
            
            $comunidad->incidencia = false;
            if ($this->comunidadTieneIncidencia($comunidad, $incidencias)) {
                $comunidad->incidencia = true;
            }
        }

        $data = ['comunidades' => $comunidades, 'total' => $total];

        $this->render('comunidad/comunidad_view', $data);
    }
    
    private function comunidadTieneIncidencia($comunidad, $incidencias) {
        foreach ($incidencias as $incidencia) {                
            if ($comunidad->cod == $incidencia->cod) {
                return true;
            }
        }
        return false;
    }
    
    public function nueva() {
        if (!$_SESSION['token']) {
            $_SESSION['token'] = md5(mt_rand(1, 10000000));
        }
        
        $this->render('comunidad/nuevaComunidad_view');
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
