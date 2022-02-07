<?php

/**
 * Tabla Codigo
 *
 * @author Fran
 */
class Comunidad_model {

    private $db;

    public function __construct() {
        $this->db = new DataBase();
    }

    function getComunidades() {

        /****************************************************
         * Con datos escapados sería:
         * 
         * $this->db->prepared("select * from codigos where Poblacion=:ciudad");
         * $this->db->bind('ciudad', 'Madrid', 'string');
         * return $this->db->resultPrepared();        
         *
         * **************************************************/

        $sql = "SELECT comunidad.* from comunidad";
        
        return $this->db->result($sql);
    }

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
    
    function getTotal() {
        return $this->db->rowCount();
    }

    function getComunidad(int $cod) {
        return $this->db->result("SELECT * FROM Comunidad WHERE cod = $cod");
    }

}
