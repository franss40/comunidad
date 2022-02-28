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

    /**
     * Alta de la comunidad. Al dar el alta no se añade ni presupuesto ni
     * presidente ni vicepresidente, ya que no hay aún propiedades
     * 
     */
    public function nueva() {
        
        $data = ['info' => 'Alta Comunidad',
            'token' => $_SESSION['token']
        ];

        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRIPPED);
        $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRIPPED);
        $codigo = filter_input(INPUT_POST, 'codigo', FILTER_VALIDATE_INT);
        $poblacion = filter_input(INPUT_POST, 'poblacion', FILTER_SANITIZE_STRIPPED);
        $cuota = filter_input(INPUT_POST, 'cuota', FILTER_SANITIZE_STRIPPED);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRIPPED);
        
        if (!empty($nombre) && !empty($direccion) && !empty($poblacion) && $token == $_SESSION['token']) {

            if ($cuota!=='FIJA' && $cuota!=='VARIABLE' || !is_int($codigo)) {  
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
                $this->render('comunidad/nuevaComunidad_view', $data);
                return;
            }

            $comunidad = ['nombre' => $nombre,
                    'direccion' => $direccion,
                    'codigo' => $codigo,
                    'poblacion' => $poblacion,
                    'cuota' => $cuota
                    ];

            if ($this->model->addComunidad($comunidad)) {
                $data['info'] = 'Registro añadido correctamente';
            }            
        }

        $this->render('comunidad/nuevaComunidad_view', $data);
    }

}
