<?php

/**
 * Propiedad
 *
 * @author Fran
 */
class Propiedad extends Controller {

    public function __construct() {
        $this->addModel('Propiedad_model');
        $this->setModel('Comunidades');
    }

    public function index() {
        die('No existe esta ruta');
    }
    
    public function comunidad(int $cod) {
        $comunidad = $this->model->getComunidad($cod);
        
        if (!$comunidad) {
            die('Código de comunidad no existe - 404 not found');
        }

        $propiedades = $this->models['Propiedad_model']->getPropiedades($cod);
        $total = $this->models['Propiedad_model']->getTotal();

        $data = ['comunidad' => $comunidad[0],
            'propiedades' => $propiedades,
            'total' => $total];

        $this->render('propiedad/index', $data);
    }
    
    public function cuota(int $codComunidad, string $numberPropiedad) {
        // Los enlaces de los number de las propiedades los pongo en los html,
        // sustituyendo los espacios en blanco por guiones ( helpers), para que tenga
        // urls amigables.
        
        // Ahora vuelvo a cambiar los guiones por espacios
        $numberPropiedad = str_replace('-', ' ', $numberPropiedad);        
        
        $cuotasPtes = $this->model['Propiedades']->getCuotasPendientes($codComunidad, $numberPropiedad);
        $total = $this->model['Propiedades']->getTotal();
        
        $cuotas = $this->model['Propiedades']->getcuotas($codComunidad, $numberPropiedad);
        $comuPropiedad = $this->model['Propiedades']->getComuPropiedad($codComunidad, $numberPropiedad);
        
        if ($comuPropiedad) {
            $comuPropi = $comuPropiedad[0];
            $propietario = $comuPropiedad[0]->nombre_propietario;

            $data = ['comuPropi'        => $comuPropi,
                    'propietario'       => $propietario,
                    'cuotas'            => $cuotas,
                    'pendientes'        => $cuotasPtes,
                    'total'             => $total
                    ];
        } else {
            $data = ['comuPropi'        => '',
                    'propietario'       => '',
                    'cuotas'            => $cuotas,
                    'pendientes'        => $cuotasPtes,
                    'total'             => ''
                    ];
        }
        
        
        $this->render('propiedad/cuota', $data);
    }

}
