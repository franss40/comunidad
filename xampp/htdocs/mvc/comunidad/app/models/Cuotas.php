<?php
/**
 * Modelo referente a las cuotas de propietarios
 *
 * @author Fco Sanz
 */
class Cuotas {
    
    private $db;

    /**
     * Cargamos la base de datos para poder acceder a ella
     */
    public function __construct() {
        $this->db = new DataBase();
    }
}
