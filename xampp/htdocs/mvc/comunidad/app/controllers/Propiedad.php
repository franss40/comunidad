<?php

/**
 * Propiedad
 *
 * @author Fco Sanz
 */
class Propiedad extends Controller {

    public function __construct() {
        $this->setModel('Propiedades');
        $this->addModel('Comunidades');
    }

    public function index() {
        die('No existe esta ruta');
    }
    
    /**
     * Muestro las propiedades de la comunidad de código $cod
     * 
     * @param int $cod
     */
    public function comunidad(int $cod) {
        $comunidad = $this->models['Comunidades']->getComunidad($cod);
        
        if (!$comunidad) {
            die('Código de comunidad no existe - 404 not found');
        }

        $propiedades = $this->model->getPropiedades($cod);
        $total = $this->model->getTotal();

        $data = ['comunidad' => $comunidad,
            'propiedades' => $propiedades,
            'total' => $total];

        $this->render('propiedad/propiedad_view', $data);
    }
    
    /**
     * Añado nueva comunidad
     * 
     * @param int $codComunidad
     * @param string $nombreComunidad
     * 
     */
    public function nueva(int $codComunidad, string $nombreComunidad) {
        $data = [
            'info' => 'Alta Propiedad',
            'codComunidad' => $codComunidad,
            'nombreComunidad' => deleteUrlAmigable($nombreComunidad),
            'token' => $_SESSION['token']
        ];
        
        // recupero datos enviados mediante post de manera segura
        $filtroPost = $this->filtrarPost();
        
        // Si los datos son correctos y no están vacios...
        if (!empty($filtroPost->cod) && !empty($filtroPost->numero) && !empty($filtroPost->nombre_propietario) && !empty($filtroPost->participacion) && !empty($filtroPost->cuota) && $filtroPost->token == $_SESSION['token']) {
            $tipoPermitido = array('VIVIENDA', 'OFICINA', 'GARAJE', 'LOCAL');
            if (!in_array($filtroPost->tipo_prop, $tipoPermitido)) {  
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
                $this->render('propiedad/nuevaPropiedad_view', $data);
            }
            
            $data['info'] = 'Se ha producido un error. Pruebe más tarde';
            if ($this->model->addPropiedad($filtroPost)) {
                $data['info'] = 'Registro añadido correctamente';
            }           
        }
        
        $this->render('propiedad/nuevaPropiedad_view', $data);
    }
    
    /**
     * Edito nueva comunidad
     * 
     * @param int $codComunidad
     * @param string $nombreComunidad
     * @param string $numeroPropiedad
     * 
     */
    public function editar(int $codComunidad, string $nombreComunidad, string $numeroPropiedad) {
        require_once APPROOT . '/views/helpers_view.php';
        $data = [
            'info' => 'Editar Propiedad', 'token' => $_SESSION['token'],
            'codComunidad' => $codComunidad, 'nombreComunidad' => deleteUrlAmigable($nombreComunidad)
        ];
        
        // recupero datos enviados mediante post de manera segura
        $filtroPost = $this->filtrarPost();

        // Si los datos son correctos y no están vacios...
        if (!empty($filtroPost->cod) && !empty($filtroPost->numero) && !empty($filtroPost->nombre_propietario) && !empty($filtroPost->participacion) && !empty($filtroPost->cuota) && $filtroPost->token == $_SESSION['token']) {
            $tipoPermitido = array('VIVIENDA', 'OFICINA', 'GARAJE', 'LOCAL');
            if (!in_array($filtroPost->tipo_prop, $tipoPermitido)) {  
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
                $this->render('propiedad/nuevaPropiedad_view', $data);
            }

            $data['info'] = 'Se ha producido un error. Pruebe más tarde';
            if ($this->model->editPropiedad($filtroPost)) {
                $data['info'] = 'Registro editado correctamente';
            }
        }    

        $propiedades = $this->model->getPropiedad($codComunidad, deleteUrlAmigable($numeroPropiedad));
        $data['propiedad'] = $propiedades;
        $this->render('propiedad/editarPropiedad_view', $data);
    }
    
    /**
     * Filtrar datos de la Propiedad. Retorno null si no hay datos post
     * 
     * @return array
     */
    private function filtrarPost() {
        
        $cod = filter_input(INPUT_POST, 'cod', FILTER_SANITIZE_NUMBER_INT);
        $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRIPPED);
        $nombre_propietario = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRIPPED);
        $email_propietario = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRIPPED);
        $tf_propietario = filter_input(INPUT_POST, 'tf', FILTER_SANITIZE_STRIPPED);
        $nombre_inquilino = filter_input(INPUT_POST, 'nombreInquilino', FILTER_SANITIZE_STRIPPED);
        $tf_inquilino = filter_input(INPUT_POST, 'tfInquilino', FILTER_SANITIZE_STRIPPED);
        $superficie = filter_input(INPUT_POST, 'superficie', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $participacion = filter_input(INPUT_POST, 'participacion', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $cuota = filter_input(INPUT_POST, 'cuota', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $numero_cuenta = filter_input(INPUT_POST, 'cuenta', FILTER_SANITIZE_STRIPPED);
        $tipo_prop = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRIPPED);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRIPPED);
        
        $propiedad = new stdClass();
        $propiedad->cod = $cod; 
        $propiedad->numero = $numero;
        $propiedad->nombre_propietario = $nombre_propietario;
        $propiedad->email_propietario = $email_propietario; 
        $propiedad->tf_propietario = $tf_propietario;
        $propiedad->nombre_inquilino = $nombre_inquilino; 
        $propiedad->tf_inquilino = $tf_inquilino;
        $propiedad->superficie = $superficie; 
        $propiedad->participacion = $participacion;
        $propiedad->cuota = $cuota; 
        $propiedad->numero_cuenta = $numero_cuenta;
        $propiedad->tipo_prop = $tipo_prop;
        $propiedad->token = $token;
        
        if (empty($nombre_propietario) || empty($numero) || empty($cod)) {
            $propiedad = null;
        }
        return $propiedad;
    }
    
    /**
     * Borrado de una propiedad
     * 
     * @param int $codComunidad
     * @param string $nombreComunidad
     * @param string $numeroPropiedad
     */
    public function borrar(int $codComunidad, string $nombreComunidad, string $numeroPropiedad) {
        $numeroPropiedad = deleteUrlAmigable($numeroPropiedad);
        $data = [
                'info'   => 'Borrado Propiedad',
                'result' => "Se ha producido un error al intentar borrar la propiedad $numeroPropiedad de la comunidad $nombreComunidad"
                ];
        if ($this->model->borrarPropiedad($codComunidad, $numeroPropiedad)) {
            $data = [
                    'result'     => "Borrado con éxito de la propiedad $numeroPropiedad de la comunidad $nombreComunidad",
                    'info'       => 'Borrado Propiedad'
                    ];
        }
        $this->render('informacion_view', $data);
    }

    /**
     * hay que comprobarlo, no usado
     */
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
