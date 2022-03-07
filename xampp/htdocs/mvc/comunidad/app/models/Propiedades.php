<?php

/**
 * Propiedad_model
 *
 * @author Fco Sanz
 */
class Propiedades {

    private $db;

    public function __construct() {
        $this->db = new DataBase();
    }

    function getTotal() {
        return $this->db->rowCount();
    }

    function getPropiedades(int $codComunidad) {
        return $this->db->result("SELECT * FROM Propiedad WHERE cod = $codComunidad");
    }

    function getCuotas(int $codComunidad, string $numberPropiedad) {
        return $this->db->result("SELECT * FROM Recibo_comunidad "
            . "WHERE cod = $codComunidad AND numero = '$numberPropiedad' ORDER BY recibo_com DESC LIMIT 12");
    }
    
    function getCuotasPendientes(int $codComunidad, string $numberPropiedad) {
        $sql = "SELECT * FROM Recibo_comunidad WHERE cod = $codComunidad AND "
                . "numero = '$numberPropiedad' AND estado='IMPAGADO'";
        return $this->db->result($sql);
    }
    
    function getComuPropiedad(int $codComunidad, string $numberPropiedad) {
        /*$sql = "SELECT * FROM Comunidad, Propiedad "
                . "WHERE cod = $codComunidad AND numero = $numberPropiedad";
        */
        $sql = "SELECT * FROM Comunidad INNER JOIN Propiedad USING(cod) WHERE "
                . "cod = $codComunidad AND numero = '$numberPropiedad'";

        return $this->db->result($sql);
    }

    function getImpagados(int $codComunidad) {

        $sql = "SELECT propiedad.*, COUNT(recibo_comunidad.importe) AS suma 
                FROM propiedad, recibo_comunidad
                WHERE propiedad.cod = $codComunidad 
                AND recibo_comunidad.estado='IMPAGADO' 
                AND propiedad.numero=recibo_comunidad.numero 
                GROUP BY recibo_comunidad.importe";
        
        return $this->db->result($sql);
    }

}
