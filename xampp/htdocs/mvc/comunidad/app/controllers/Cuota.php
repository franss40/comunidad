<?php
/**
 * Gestión de todo lo necesario para lo referente a los recibos de comunidades
 *
 * @author Fco Sanz
 */
class Cuota extends Controller{
    
    /**
     * Cargamos el modelo
     */
    public function __construct() {
        $this->setModel('Cuotas');
        $this->addModel('Propiedades');
    }
    /**
     * Método no habilitado
     */
    public function index() {
        die('No existe esta ruta');
    }
    
    /**
     * Muestra el listado de las cuotas de una determinada propiedad
     * El 'cuotaPendiente' va a identificar si es cuotas o cuotas pendientes
     * 
     * @param int $codComunidad
     * @param string $nombreComunidad
     * @param string $numeroPropiedad
     */
    public function ver(int $codComunidad, string $nombreComunidad, string $numeroPropiedad) {
        
        $cuotas = $this->model->getCuotas($codComunidad, deleteUrlAmigable($numeroPropiedad));
        $total = $this->model->getTotal();
        $data = [
            'cuotaPendiente' => false,
            'cuotas'    => $cuotas,
            'total' => $total,
            'codComunidad' => $codComunidad,
            'nombreComunidad' => deleteUrlAmigable($nombreComunidad),
            'propiedad'  => deleteUrlAmigable($numeroPropiedad)
            ];
        $this->render('cuota/cuota_view', $data);
    }
    
    /**
     * Cambio el estado de cuota
     * 
     * @param int $recibo
     * @param int $codComunidad
     * @param string $nombreComunidad
     * @param string $propiedad
     */
    public function cambiarEstadoCuota(int $recibo, int $codComunidad, string $nombreComunidad, string $propiedad) {
        $data = [
                'info' => "Cambio recibo número $recibo",
                'result' => "Se ha producido un error al intentar cambiar el recibo número $recibo"
                ];
        if ($this->model->cambiarEstadoCuota($recibo)) {
            $enlace = URLROOT.'/cuota/ver/'.$codComunidad.'/'.urlAmigable($nombreComunidad).'/'. urlAmigable($propiedad);
            $data = ['result' => "Registro actualizado. <strong><a href='$enlace'>Volver</a></strong>",
                     'info' => 'Estado Cuota'];
        }
        $this->render('informacion_view', $data);
    }
    
    /**
     * Muestra el listado de las cuotas pendientes de una determinada propiedad
     * El 'cuotaPendiente' va a identificar si es cuotas o cuotas pendientes
     * 
     * @param int $codComunidad
     * @param string $nombreComunidad
     * @param string $numeroPropiedad
     */
    public function cuotasPendientes(int $codComunidad, string $nombreComunidad, string $numeroPropiedad) {
        $cuotas = $this->model->getCuotasPendientes($codComunidad, deleteUrlAmigable($numeroPropiedad));
        $total = $this->model->getTotal();
        
        $data = [
            'cuotaPendiente' => true,
            'cuotas'    => $cuotas,
            'total' => $total,
            'codComunidad' => $codComunidad,
            'nombreComunidad' => deleteUrlAmigable($nombreComunidad),
            'propiedad'  => deleteUrlAmigable($numeroPropiedad)
            ];
        $this->render('cuota/cuota_view', $data);
    }
    
    public function crearCuotas(int $codComunidad, string $comunidad) {
        $propiedades = $this->models['Propiedades']->getPropiedades($codComunidad);
        $cuota = $this->filtrarPost();
        print_r($cuota->propiedad);
        $data = [
            'info' =>  deleteUrlAmigable($comunidad),
            'nombreComunidad'   => $comunidad,
            'codComunidad'      => $codComunidad,
            'propiedades'       => $propiedades,
            'token' => $_SESSION['token']
            ];
        $this->render('cuota/crearCuota_view', $data);
    }
    
    private function filtrarPost() {
        $fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_STRIPPED);
        $concepto = filter_input(INPUT_POST, 'concepto', FILTER_SANITIZE_STRIPPED);
        $importe = filter_input(INPUT_POST, 'importe', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $propiedad = filter_input_array(INPUT_POST, 'propiedad', FILTER_SANITIZE_STRIPPED);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRIPPED);
        
        $cuota = new stdClass();
        $cuota->fecha = $fecha;
        $cuota->concepto = $concepto;
        $cuota->importe = $importe;
        $cuota->propiedad = $propiedad; 
        $cuota->token = $token;

        if (empty($fecha) || empty($concepto) || empty($importe)) {
            $cuota = null;
        }
        return $cuota;
    }
}
