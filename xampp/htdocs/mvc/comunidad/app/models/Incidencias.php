<?php

/**
 * Modelo de Incidencias
 *
 * @author Fran
 */
class Incidencias {

    private $db;

    public function __construct() {
        $this->db = new DataBase();
    }
    /**
     * Obtiene todas la incidencias sin solucionar de las comunidades
     * 
     * @return array
     */
    public function getIncidencias() {
        $sql = "SELECT * FROM incidencia WHERE solucionado=false";

        return $this->db->result($sql);
    }

}
