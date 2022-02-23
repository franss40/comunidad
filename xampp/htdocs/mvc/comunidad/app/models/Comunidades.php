<?php

/**
 * Modelo de Comunidades
 *
 * @author Fran
 */
class Comunidades {

    private $db;

    public function __construct() {
        $this->db = new DataBase();
    }
    
    /**
     * Retorna las comunidades existentes
     * 
     * @return array
     */
    function getComunidades() {

        /***************************************************
         * Con datos escapados sería:
         * 
         * $this->db->prepared("select * from codigos where Poblacion=:ciudad");
         * $this->db->bind('ciudad', 'Madrid', 'string');
         * return $this->db->resultPrepared();        
         *
         * ************************************************* */

        $sql = "SELECT * from comunidad";

        return $this->db->result($sql);
    }

    /**
     * Retorna el importe de las cuotas ptes de cada comunidad
     * 
     * @return array
     */
    function getComuConCuotasPtes() {
        $sql = "SELECT comunidad.nombre, COUNT(recibo_comunidad.importe) AS cuantos, 
                SUM(recibo_comunidad.importe) AS suma
                FROM comunidad
                LEFT JOIN propiedad ON comunidad.cod = propiedad.cod
                LEFT JOIN recibo_comunidad ON propiedad.numero = recibo_comunidad.numero
                WHERE recibo_comunidad.estado='IMPAGADO'
                GROUP BY comunidad.cod, comunidad.nombre";

        return $this->db->result($sql);
    }

    /**
     * Rerotrn ael número total de registros
     * 
     * @return int
     */
    function getTotal() {
        return $this->db->rowCount();
    }

    /**
     * Retorna una comunidad según su cod
     * 
     * @param int $cod
     * @return array
     */
    function getComunidad(int $cod) {
        return $this->db->result("SELECT * FROM comunidad WHERE cod = $cod");
    }

}