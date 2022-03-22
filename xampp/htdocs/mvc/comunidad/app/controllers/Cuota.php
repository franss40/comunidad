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
    }
    /**
     * Método no habilitado
     */
    public function index() {
        die('No existe esta ruta');
    }
    
    /**
     * Muestra el listado de las cuotas de una determinada propiedad
     * 
     * @param int $codComunidad
     * @param string $nombreComunidad
     * @param string $numeroPropietario
     */
    public function ver(int $codComunidad, string $nombreComunidad, string $numeroPropietario) {
        
        $cuotas = $this->model->getCuotas($codComunidad, deleteUrlAmigable($numeroPropietario));
        $total = $this->model->getTotal();
        $data = [
            'cuotas'    => $cuotas,
            'total' => $total,
            'codComunidad' => $codComunidad,
            'nombreComunidad' => deleteUrlAmigable($nombreComunidad),
            'propiedad'  => deleteUrlAmigable($numeroPropietario)
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
}
