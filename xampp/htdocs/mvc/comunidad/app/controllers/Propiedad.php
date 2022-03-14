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
     * Muestro la comunidad de código $cod
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

        $data = ['comunidad' => $comunidad[0],
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
        $cod = $codComunidad;
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRIPPED);
        $vivienda = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRIPPED);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRIPPED);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRIPPED);
        $tf = filter_input(INPUT_POST, 'tf', FILTER_SANITIZE_STRIPPED);
        $nombreInquilino = filter_input(INPUT_POST, 'nombreInquilino', FILTER_SANITIZE_STRIPPED);
        $tfInquilino = filter_input(INPUT_POST, 'tfInquilino', FILTER_SANITIZE_STRIPPED);
        $superficie = filter_input(INPUT_POST, 'superficie', FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        $participacion = filter_input(INPUT_POST, 'participacion', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $cuota = filter_input(INPUT_POST, 'cuota', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $cuenta = filter_input(INPUT_POST, 'cuenta', FILTER_SANITIZE_STRIPPED);
        $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRIPPED);
        
        // Si los datos son correctos y no están vacios...
        if (!empty($cod) && !empty($vivienda) && !empty($nombre) && !empty($participacion) && !empty($cuota) && $token == $_SESSION['token']) {
            $tipoPermitido = array('VIVIENDA', 'OFICINA', 'GARAJE', 'LOCAL');
            if (!in_array($tipo, $tipoPermitido)) {  
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
                $this->render('propiedad/nuevaPropiedad_view', $data);
                return;
            }
            
            $propiedad = new stdClass();
            $propiedad->cod = $cod;
            $propiedad->numero = $vivienda;
            $propiedad->nombre_propietario = $nombre;
            $propiedad->tf_propietario = $tf;
            $propiedad->email_propietario = $email;            
            $propiedad->nombre_inquilino = $nombreInquilino;
            $propiedad->tf_inquilino = $tfInquilino;            
            $propiedad->superficie = $superficie;            
            $propiedad->participacion = $participacion;
            $propiedad->cuota = $cuota;
            $propiedad->numero_cuenta = $cuenta;
            $propiedad->tipo_prop = $tipo;
            
            if ($this->model->addPropiedad($propiedad)) {
                $data['info'] = 'Registro añadido correctamente';
            } else {
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
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
            'info' => 'Editar Propiedad',
            'token' => $_SESSION['token'],
            'codComunidad' => $codComunidad,
            'nombreComunidad' => $nombreComunidad
        ];
        
        // recupero datos enviados mediante post de manera segura
        $cod = $codComunidad;
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRIPPED);
        $vivienda = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRIPPED);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRIPPED);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRIPPED);
        $tf = filter_input(INPUT_POST, 'tf', FILTER_SANITIZE_STRIPPED);
        $nombreInquilino = filter_input(INPUT_POST, 'nombreInquilino', FILTER_SANITIZE_STRIPPED);
        $tfInquilino = filter_input(INPUT_POST, 'tfInquilino', FILTER_SANITIZE_STRIPPED);
        $superficie = filter_input(INPUT_POST, 'superficie', FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        $participacion = filter_input(INPUT_POST, 'participacion', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $cuota = filter_input(INPUT_POST, 'cuota', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $cuenta = filter_input(INPUT_POST, 'cuenta', FILTER_SANITIZE_STRIPPED);
        $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRIPPED);
        
        // Si los datos son correctos y no están vacios...
        if (!empty($cod) && !empty($vivienda) && !empty($nombre) && !empty($participacion) && !empty($cuota) && $token == $_SESSION['token']) {
            $tipoPermitido = array('VIVIENDA', 'OFICINA', 'GARAJE', 'LOCAL');
            if (!in_array($tipo, $tipoPermitido)) {  
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
                $this->render('propiedad/nuevaPropiedad_view', $data);
                return;
            }
            
            $propiedad = new stdClass();
            $propiedad->cod = $cod;
            $propiedad->numero = $vivienda;
            $propiedad->nombre_propietario = $nombre;
            $propiedad->tf_propietario = $tf;
            $propiedad->email_propietario = $email;            
            $propiedad->nombre_inquilino = $nombreInquilino;
            $propiedad->tf_inquilino = $tfInquilino;            
            $propiedad->superficie = $superficie;            
            $propiedad->participacion = $participacion;
            $propiedad->cuota = $cuota;
            $propiedad->numero_cuenta = $cuenta;
            $propiedad->tipo_prop = $tipo;
            
            if ($this->model->editPropiedad($propiedad)) {
                $data['info'] = 'Registro editado correctamente';
            } else {
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
            }
        }    

        $propiedades = $this->model->getPropiedad($codComunidad, $numeroPropiedad);
        $data['propiedad'] = $propiedades;
        $this->render('propiedad/editarPropiedad_view', $data);
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
