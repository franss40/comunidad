<?php

/**
 * Propiedad
 *
 * @author Fran
 */
class Propiedades extends Controller {

    public function __construct() {
        $this->getModel('Propiedad_model');
        $this->getModel('Comunidad_model');
    }

    public function index() {
        die('No existe esta ruta');
    }
    
    public function comunidad(int $cod) {
        $comunidad = $this->model['Comunidad_model']->getComunidad($cod);

        if (!$comunidad) {
            die('Código de comunidad no existe - 404 not found');
        }

        $propiedades = $this->model['Propiedad_model']->getPropiedades($cod);
        $total = $this->model['Propiedad_model']->getTotal();

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
        
        $cuotasPtes = $this->model['Propiedad_model']->getCuotasPendientes($codComunidad, $numberPropiedad);
        $total = $this->model['Propiedad_model']->getTotal();
        
        $cuotas = $this->model['Propiedad_model']->getcuotas($codComunidad, $numberPropiedad);
        $comuPropiedad = $this->model['Propiedad_model']->getComuPropiedad($codComunidad, $numberPropiedad);
        
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
