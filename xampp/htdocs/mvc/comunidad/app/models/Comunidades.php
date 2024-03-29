<?php

/**
 * Modelo de Comunidades
 *
 * @author Fco Sanz
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
    public function getComunidades() {

        /**************************************************
         * Con datos escapados sería:
         * 
         * $this->db->prepared("select * from codigos where Poblacion=:ciudad");
         * $this->db->bind('ciudad', 'Madrid', 'string');
         * return $this->db->resultPrepared();        
         *
         * **************************************************/

        $sql = "SELECT * FROM comunidad ORDER BY nombre";
        return $this->db->result($sql);
    }

    /**
     * Retorna el importe de las cuotas ptes de cada comunidad
     * 
     * @return array
     */
    public function getComuConCuotasPtes() {
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
     * Retorna el importe de las cuotas ptes de cada comunidad dado el cod comunidad
     * 
     * @return array
     */
    public function getComuConCuotasPte(int $cod) {
        $sql = "SELECT COUNT(recibo_comunidad.importe) AS cuantos, 
                SUM(recibo_comunidad.importe) AS suma
                FROM comunidad
                LEFT JOIN propiedad ON comunidad.cod = propiedad.cod
                LEFT JOIN recibo_comunidad ON propiedad.numero = recibo_comunidad.numero
                WHERE recibo_comunidad.estado='IMPAGADO' AND comunidad.cod = $cod
                GROUP BY comunidad.cod, comunidad.nombre";

        return $this->db->result($sql);
    }

    /**
     * Adiciono una comunidad
     * 
     * @param integer $comunidad
     * @return boolean
     */
    public function addComunidad($comunidad) {
        $sql = "INSERT INTO comunidad(nombre, calle, cp, poblacion, tipo_cuota, presupuesto, iban) 
                    VALUES(:nombre, :direccion, :codigo, :poblacion, :cuota, :presupuesto, :iban)";
        $this->db->prepared($sql);
        $this->db->bind('nombre', $comunidad->nombre, 'string');
        $this->db->bind('direccion', $comunidad->calle, 'string');
        $this->db->bind('codigo', $comunidad->cp, 'int');
        $this->db->bind('poblacion', $comunidad->poblacion, 'string');
        $this->db->bind('cuota', $comunidad->tipo_cuota, 'string');
        $this->db->bind('presupuesto', $comunidad->presupuesto, 'int');
        $this->db->bind('iban', $comunidad->iban, 'string');

        return $this->db->noResultPrepared();
    }

    public function borrarComunidad(int $cod) {
        $sql = "DELETE FROM comunidad WHERE cod = :cod";
        $this->db->prepared($sql);
        $this->db->bind('cod', $cod, 'int');
        return $this->db->noResultPrepared();
    }

    /**
     * Edito una comunidad
     * 
     * @param int $comunidad
     * @return boolean
     */
    public function editComunidad($comunidad) {
        $sql = "UPDATE comunidad SET nombre=:nombre, calle=:direccion, cp=:codigoPostal, poblacion=:poblacion, tipo_cuota=:tipoCuota, presupuesto=:presupuesto, presidente=:presidente, vicepresidente=:vicepresidente, iban=:iban WHERE cod=:cod";
        $this->db->prepared($sql);
        $this->db->bind('nombre', $comunidad->nombre, 'string');
        $this->db->bind('direccion', $comunidad->calle, 'string');
        $this->db->bind('codigoPostal', $comunidad->cp, 'int');
        $this->db->bind('poblacion', $comunidad->poblacion, 'string');
        $this->db->bind('tipoCuota', $comunidad->tipo_cuota, 'string');
        $this->db->bind('presupuesto', $comunidad->presupuesto, 'int');
        $this->db->bind('presidente', $comunidad->presidente, 'string');
        $this->db->bind('vicepresidente', $comunidad->vicepresidente, 'string');
        $this->db->bind('iban', $comunidad->iban, 'string');
        $this->db->bind('cod', $comunidad->cod, 'int');

        return $this->db->noResultPrepared();
    }

    /**
     * Retorna ael número total de registros
     * 
     * @return int
     */
    public function getTotal() {
        return $this->db->rowCount();
    }

    /**
     * Retorna una comunidad según su cod
     * 
     * @param int $cod
     * @return array
     */
    public function getComunidad(int $cod) {
        $sql = "SELECT * FROM comunidad WHERE cod =:cod";
        $this->db->prepared($sql);
        $this->db->bind('cod', $cod, 'int');
        return $this->db->resultPreparedOne();
    }
    /**
     * Devuelve el último id introducido en la base de datos
     * 
     * @return int
     */
    public function lastId() {
        return $this->db->lastID();
    }
}
