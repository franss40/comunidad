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
    
    public function ver(int $codComunidad, string $numeroPropietario) {
        $data = ['total' => 3];
        $this->render('cuota/cuota_view', $data);
    }
}
