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
    
    /**
     * Aquí hacemos los test de todos los casos de uso; uno por uno
     */
    public function testComunidad() {
        $this->testListComunidad();
        $this->testEditComunidad();
    }
    /**
     * Probamos el listado de comunidades con el cod numero 1
     * El número total de comunidades y las cuotas pendientes
     */
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
        $esperado->tipo_cuota = 'FIJA';
        $esperado->presidente = 'BAJO B';
        $esperado->vicepresidente = null;
        $esperado->iban = null;
        
        $this->assertArrayEquals($esperado, $comunidades, 'Test listado comunidad');
        $this->assertEquals(3, $total, 'Test número de comunidades');
        
        $esperado2 = new stdClass();
        $esperado2->nombre = 'RESIDENCIAL AMAPOLA';
        $esperado2->cuantos = 5;
        $esperado2->suma = 211.30;
        $this->assertArrayEquals($esperado2, $this->model->getComuConCuotasPtes(), 'Test cuotas pendientes');
    }
    
    /**
     * Editamos un registro, para luego comprobar que se han grabado correctamente
     */
    private function testEditComunidad() {
        $esperado = new stdClass();
        $esperado->cod = 1;
        $esperado->nombre = 'RESIDENCIAL AMAPOLA NUEVA';
        $esperado->calle = 'C/AMAPOLA 28 NUEVA';
        $esperado->cp = '11271';
        $esperado->poblacion = 'ALGECIRAS NUEVA';
        $esperado->presupuesto = 10000;
        $esperado->tipo_cuota = 'VARIABLE';
        $esperado->presidente = null;
        $esperado->vicepresidente = 'BAJO B';
        $esperado->iban = null;
        
        $this->model->editComunidad($esperado);
        
        $comunidades = $this->model->getComunidades();
        $total = $this->model->getTotal();
        
        $this->assertArrayEquals($esperado, $comunidades, 'Test list - editar comunidad');
        $this->assertEquals(3, $total, 'Test count - editar comunidad');
        
        // Volvemos a antes del cambio
        $esperado2 = new stdClass();
        $esperado2->cod = 1;
        $esperado2->nombre = 'RESIDENCIAL AMAPOLA';
        $esperado2->calle = 'C/AMAPOLA 28';
        $esperado2->cp = '11270';
        $esperado2->poblacion = 'ALGECIRAS';
        $esperado2->presupuesto = 6000;
        $esperado2->tipo_cuota = 'FIJA';
        $esperado2->presidente = 'BAJO B';
        $esperado2->vicepresidente = null;
        $esperado2->iban = null;
        
        $this->model->editComunidad($esperado2);
    }

    public function testAddComunidad() {
        $esperado = new stdClass();
        $esperado->cod = 1;
        $esperado->nombre = 'RESIDENCIAL AMAPOLA NUEVA';
        $esperado->calle = 'C/AMAPOLA 28 NUEVA';
        $esperado->cp = '11271';
        $esperado->poblacion = 'ALGECIRAS NUEVA';
        $esperado->presupuesto = 10000;
        $esperado->tipo_cuota = 'VARIABLE';
        $esperado->presidente = null;
        $esperado->vicepresidente = 'BAJO B';
        $esperado->iban = null;
        
    }
    
    /**
     * Comprobamos si el parámetro esperado está incluido en el parámetro actúal
     * y mostramos la salida. Son arrays.
     * 
     * @param type $esperado
     * @param type $actual
     * @param type $salida
     */
    private function assertArrayEquals($esperado, $actual, $salida) {
        if (in_array($esperado, $actual)) {
            echo "<h3>$salida: <strong style='color: green'>OK</strong></h3>";
        } else {
            echo "<h3>$salida: <strong style='color: green'>FALSE</strong></h3>";
        }
    }
    /**
     * La diferencia con el anterior es que aquí no son arrays. 
     * Comprobamos que sean iguales los valores
     * 
     * @param type $esperado
     * @param type $actual
     * @param type $salida
     */
    private function assertEquals($esperado, $actual, $salida) {
        if ($esperado==$actual) {
            echo "<h3>$salida: <strong style='color: green'>OK</strong></h3>";
        } else {
            echo "<h3>$salida: <strong style='color: green'>FALSE</strong></h3>";
        }
    }
}
