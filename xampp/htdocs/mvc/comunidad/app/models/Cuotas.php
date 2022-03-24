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
     * Devuelve las cuotas pendientes de una determinada propiedad
     * 
     * @param int $codComunidad
     * @param string $propiedad
     * @return array
     */
    public function getCuotasPendientes(int $codComunidad, string $propiedad) {
        $sql = 'SELECT * '
                . 'FROM recibo_comunidad '
                . 'WHERE cod =:cod AND numero =:numero AND estado="IMPAGADO"'
                . 'ORDER BY recibo_com';
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
        $fecha_pago = "'".date('Y-m-d')."'";
        
        $sql = "UPDATE recibo_comunidad SET estado=:estado, fecha_pago=$fecha_pago WHERE recibo_com=$recibo";
        
        if ($this->getCuota($recibo)->estado=='PAGADO') {
            $cambio = 'IMPAGADO';
            $sql = "UPDATE recibo_comunidad SET estado=:estado, fecha_pago=null WHERE recibo_com=$recibo";            
        }

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
    
    /**
     * Crea un recibo de cuotas para una determinada propiedad
     * 
     * @param array $propiedades
     * @param string $filtroPost
     * @return boolean
     * @throws Exception
     */
    public function crearCuota($propiedades, $filtroPost) {
        try {
            $mes = array(
                1       => 'ENERO',
                2       => 'FEBRERO',
                3       => 'MARZO',
                4       => 'ABRIL',
                5       => 'MAYO',
                6       => 'JUNIO',
                7       => 'JULIO',
                8       => 'AGOSTO',
                9       => 'SEPTIEMBRE',
                10       => 'OCTUBRE',
                11      => 'NOVIEMBRE',
                12      => 'DICIEMBRE'
            );
            
            $fecha_recibo = "{$filtroPost->ano}/{$filtroPost->mes}/1";

            $concepto = "CUOTA ORDINARIA {$mes[$filtroPost->mes]} {$filtroPost->ano}";

            $this->db->beginT();
            
            foreach ($propiedades as $propiedad) {
                $importe = $propiedad->cuota;
                
                if ($filtroPost->tipoCuota=='EXTRAORDINARIA') {
                    $importe = $filtroPost->importe;
                    $concepto = "CUOTA EXTRAORDINARIA {$mes[$filtroPost->mes]} {$filtroPost->ano}. {$filtroPost->concepto}";
                }
                if (in_array($propiedad->numero, $filtroPost->propiedad )) {
                    $estado = 'PAGADO';  
                    $fecha_pago = $fecha_recibo;
                } else {
                    $estado = 'IMPAGADO';
                    $fecha_pago = null;
                }
                $sql = "INSERT INTO recibo_comunidad
                        (cod, numero, fecha_recibo, fecha_pago, importe, concepto, estado) 
                        VALUES(
                        :cod, :num, '$fecha_recibo', '$fecha_pago', $importe, :concepto, '$estado')";

                $this->db->prepared($sql);
                $this->db->bind('num', $propiedad->numero, 'string');
                $this->db->bind('cod', $propiedad->cod, 'int');                   
                $this->db->bind('concepto', $concepto, 'string'); 

                if (!$this->db->noResultPrepared()) {
                    throw new Exception('Error');
                }                
            }

            $this->db->endT();
            return true;
        } catch (Exception $ex) {
            echo $ex;
            $this->db->backT();
            return false;
        }        
    }
}
