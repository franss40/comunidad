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
        if (!isset($_SESSION['token'])) {
            $_SESSION['token'] = md5(mt_rand(1, 10000000));
        }
        
        $cod = filter_input(INPUT_POST, 'cod', FILTER_SANITIZE_STRIPPED);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRIPPED);
        $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRIPPED);
        $codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_STRIPPED);
        $poblacion = filter_input(INPUT_POST, 'poblacion', FILTER_SANITIZE_STRIPPED);
        $cuota = filter_input(INPUT_POST, 'cuota', FILTER_SANITIZE_STRIPPED);
        $presupuesto = filter_input(INPUT_POST, 'presupuesto', FILTER_SANITIZE_STRIPPED);
        
        if (!empty($cod) && !empty($nombre) && !empty($direccion) && !empty($codigo)&& !empty($poblacion) && !empty($cuota) && $token == $_SESSION['token']) {
            
        }
        
        $data = ['action' => 'add', 
                'infoAction' => "Alta Comunidad", 
                'soloLectura' => 'disabled',
                'token' => $_SESSION['token']
                ];
        $this->render('comunidad/nuevaComunidad_view', $data);
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
