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

    /**
     * Devuelve el total de registros
     * 
     * @return int
     */
    function getTotal() {
        return $this->db->rowCount();
    }

    /**
     * Devuelve las propiedades de una determinada comunidad
     * 
     * @param int $codComunidad
     * @return array
     */
    function getPropiedades(int $codComunidad) {
        return $this->db->result("SELECT * FROM Propiedad WHERE cod = $codComunidad");
    }

    /**
     * Devuelve las cuotas de una propiedad determinada
     * 
     * @param int $codComunidad
     * @param string $numberPropiedad
     * @return array
     */
    function getCuotas(int $codComunidad, string $numberPropiedad) {
        return $this->db->result("SELECT * FROM Recibo_comunidad "
            . "WHERE cod = $codComunidad AND numero = '$numberPropiedad' ORDER BY recibo_com DESC LIMIT 12");
    }
    
    /**
     * Devuelve las cuotas pendientes de una propiedad 
     * 
     * @param int $codComunidad
     * @param string $numberPropiedad
     * @return array
     */
    function getCuotasPendientes(int $codComunidad, string $numberPropiedad) {
        $sql = "SELECT * FROM Recibo_comunidad WHERE cod = $codComunidad AND "
                . "numero = '$numberPropiedad' AND estado='IMPAGADO'";
        return $this->db->result($sql);
    }
    
    /**
     * Devuelve los datos de una determinada comunidad y propiedad
     * 
     * @param int $codComunidad
     * @param string $numberPropiedad
     * @return array
     */
    function getComuPropiedad(int $codComunidad, string $numberPropiedad) {
        /*$sql = "SELECT * FROM Comunidad, Propiedad "
                . "WHERE cod = $codComunidad AND numero = $numberPropiedad";
        */
        $sql = "SELECT * FROM Comunidad INNER JOIN Propiedad USING(cod) WHERE "
                . "cod = $codComunidad AND numero = '$numberPropiedad'";

        return $this->db->result($sql);
    }
    
    /**
     * Devuelve los impagados de una comunidad
     * 
     * @param int $codComunidad
     * @return array
     */
    function getImpagados(int $codComunidad) {

        $sql = "SELECT propiedad.*, COUNT(recibo_comunidad.importe) AS suma 
                FROM propiedad, recibo_comunidad
                WHERE propiedad.cod = $codComunidad 
                AND recibo_comunidad.estado='IMPAGADO' 
                AND propiedad.numero=recibo_comunidad.numero 
                GROUP BY recibo_comunidad.importe";
        
        return $this->db->result($sql);
    }

    /**
     * Añado una propiedad de una comunidad determinada
     * 
     * @param int $propiedad
     * @return boolean
     */
    public function addPropiedad(array $propiedad) {
        $sql = "INSERT INTO propiedad(numero, cod, nombre_propietario  , tf_propietario, email_propietario, nombre_inquilino, tf_inquilino, superficie, participacion, cuota, numero_cuenta, tipo_prop) 
                VALUES(:numero, :cod, :nombre_propietario, :tf_propietario, :email_propietario, :nombre_inquilino, :tf_inquilino, :superficie, :participacion, :cuota, :numero_cuenta, :tipo)";

        $this->db->prepared($sql);
        $this->db->bind('numero', $propiedad->numero, 'string');
        $this->db->bind('cod', $propiedad->cod, 'int');
        $this->db->bind('nombre_propietario', $propiedad->nombre_propietario, 'string');
        $this->db->bind('tf_propietario', $propiedad->tf_propietario, 'string');
        $this->db->bind('email_propietario', $propiedad->email_propietario, 'string');
        $this->db->bind('nombre_inquilino', $propiedad->nombre_inquilino, 'string');
        $this->db->bind('tf_inquilino', $propiedad->tf_inquilino, 'string');
        $this->db->bind('superficie', $propiedad->superficie, 'string');
        $this->db->bind('participacion', $propiedad->participacion, 'string');
        $this->db->bind('cuota', $propiedad->cuota, 'string');
        $this->db->bind('numero_cuenta', $propiedad->numero_cuenta, 'string');
        $this->db->bind('tipo', $propiedad->tipo_prop, 'string');
        
        return $this->db->noResultPrepared();
    }
    
    /**
     * Edito una propiedad determinada
     * 
     * @param array $propiedad
     * @return boolean
     */
    public function editPropiedad($propiedad) {
        $sql = "UPDATE propiedad SET nombre_propietario=:nombre_propietario, tf_propietario=:tf_propietario, email_propietario=:email_propietario, nombre_inquilino=:nombre_inquilino, tf_inquilino=:tf_inquilino, superficie=:superficie, participacion=:participacion, cuota=:cuota, numero_cuenta=:numero_cuenta, tipo_prop=:tipo WHERE numero=:numero AND cod=:cod";
        
        $this->db->prepared($sql);
        $this->db->bind('nombre_propietario', $propiedad->nombre_propietario, 'string');
        $this->db->bind('tf_propietario', $propiedad->tf_propietario, 'string');
        $this->db->bind('email_propietario', $propiedad->email_propietario, 'string');
        $this->db->bind('nombre_inquilino', $propiedad->nombre_inquilino, 'string');
        $this->db->bind('tf_inquilino', $propiedad->tf_inquilino, 'string');
        $this->db->bind('superficie', $propiedad->superficie, 'string');
        $this->db->bind('participacion', $propiedad->participacion, 'string');
        $this->db->bind('cuota', $propiedad->cuota, 'string');
        $this->db->bind('numero_cuenta', $propiedad->numero_cuenta, 'string');
        $this->db->bind('tipo', $propiedad->tipo_prop, 'string');
        $this->db->bind('numero', $propiedad->numero, 'string');
        $this->db->bind('cod', $propiedad->cod, 'int');
        
        return $this->db->noResultPrepared();
    }
    
    /**
     * Obtengo una propiedad determinada, dado el número de esa propiedad y el cod comunidad
     * 
     * @param int $codComunidad
     * @param string $numeroPropiedad
     * @return array
     */
    public function getPropiedad(int $codComunidad, string $numeroPropiedad) {
        $sql = "SELECT * FROM propiedad WHERE numero=:numero AND cod =:cod";
        $this->db->prepared($sql);
        $this->db->bind('numero', $numeroPropiedad, 'string');
        $this->db->bind('cod', $codComunidad, 'int');
        return $this->db->resultPreparedOne();
    }
}
