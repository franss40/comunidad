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

    /**
     * Devuelve las últimas 12 cuotas de una determinada propiedad
     * 
     * @param int $codComunidad
     * @param string $propiedad
     * @return array
     */
    public function getCuotas(int $codComunidad, string $propiedad) {
        $sql = 'SELECT * '
                . 'FROM recibo_comunidad '
                . 'WHERE cod =:cod AND numero =:numero '
                . 'ORDER BY recibo_com DESC LIMIT 12';
        $this->db->prepared($sql);
        $this->db->bind('cod', $codComunidad, 'int');
        $this->db->bind('numero', $propiedad, 'string');
        return $this->db->resultPrepared();
    }

    /**
     * Devuelve el total de registros
     * 
     * @return int
     */
    public function getTotal() {
        return $this->db->rowCount();
    }

    /**
     * Cambiamos el estado de la cuota de pagado a impagado o viceversa
     * 
     * @param int $recibo
     * @return boolean
     */
    public function cambiarEstadoCuota(int $recibo) {
        $cambio = 'PAGADO';
        if ($this->getCuota($recibo)->estado=='PAGADO') {
            $cambio = 'IMPAGADO';
        }
        
        $sql = "UPDATE recibo_comunidad SET estado=:estado WHERE recibo_com=$recibo";
        $this->db->prepared($sql);
        $this->db->bind('estado', $cambio, 'string');
        return $this->db->noResultPrepared();
    }
    
    /**
     * Devuelve la cuota de ese número de recibo
     * 
     * @param int $cuota
     * @return array
     */
    public function getCuota(int $cuota) {
        $sql = 'SELECT * '
                . 'FROM recibo_comunidad '
                . 'WHERE recibo_com =:recibo';
        $this->db->prepared($sql);
        $this->db->bind('recibo', $cuota, 'int');
        return $this->db->resultPreparedOne();
    }
}
