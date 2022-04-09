<?php

/**
 * Prueba los distintos módulos
 *
 * @author Fco Sanz
 */
class Pruebatest extends Controller{
    /**
     * Cargamos los modelos
     */
    public function __construct() {
        $this->setModel('Comunidades');
    }
    
    public function testComunidad() {
        $this->testListComunidad();
    }
    
    // probamos el listado de comunidades con el cod numero 1
    // Y también el número total de comunidades
    private function testListComunidad() {
        
        $comunidades = $this->model->getComunidades();
        $total = $this->model->getTotal();
        
        $esperado = new stdClass();
        $esperado->cod = 1;
        $esperado->nombre = 'RESIDENCIAL AMAPOLA';
        $esperado->calle = 'C/AMAPOLA 28';
        $esperado->cp = '11270';
        $esperado->poblacion = 'ALGECIRAS';
        $esperado->presupuesto = 6000;
        $esperado->tipo_cuota = 'VARIABLE';
        $esperado->presidente = 'BAJO B';
        $esperado->vicepresidente = null;
        $esperado->iban = null;
        
        $this->assertArrayEquals($esperado, $comunidades, 'Test listado comunidad');
        $this->assertEquals(3, $total, 'Test número de comunidades');
    }
    
    private function testEditComunidad() {
        
    }


    private function assertArrayEquals($esperado, $actual, $salida) {
        if (in_array($esperado, $actual)) {
            echo "<h3>$salida: <strong style='color: green'>OK</strong></h3>";
        } else {
            echo "<h3>$salida: <strong style='color: green'>FALSE</strong></h3>";
        }
    }
    private function assertEquals($esperado, $actual, $salida) {
        if ($esperado==$actual) {
            echo "<h3>$salida: <strong style='color: green'>OK</strong></h3>";
        } else {
            echo "<h3>$salida: <strong style='color: green'>FALSE</strong></h3>";
        }
    }
}
