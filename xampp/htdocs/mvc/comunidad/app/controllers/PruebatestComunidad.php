<?php
/**
 * Prueba del módulo de comunidad
 *
 * @author Fco Sanz
 */
class PruebatestComunidad extends Controller{
    /**
     * Cargamos los modelos
     */
    public function __construct() {
        $this->setModel('Comunidades');
        $this->index();
    }
    
    /**
     * Aquí hacemos los test de todos los casos de uso (CU); uno por uno
     */
    private function index() {
        $this->testListComuni(); // CU Consultar Comunidad / Cuotas Ptes
        $this->testEditComuni(); // CU Editar Comunidad
        $idAlta = $this->testAddComuni(); // CU Alta Comunidad
        $this->testDeleteComuni($idAlta); // CU Borrar Comunidad
    }
    
    /**
     * Probamos el listado de comunidades con el cod numero 1
     * El número total de comunidades y las cuotas pendientes
     */
    private function testListComuni() {
        
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
        
        assertArrayEquals($esperado, $comunidades, 'Test - Consultar Comunidad');
        assertEquals(3, $total, 'Test número de Comunidades - Consultar Comunidad');
        
        $esperado2 = new stdClass();
        $esperado2->nombre = 'RESIDENCIAL AMAPOLA';
        $esperado2->cuantos = 5;
        $esperado2->suma = 211.30;
        assertArrayEquals($esperado2, $this->model->getComuConCuotasPtes(), 'Test - Cuotas Pendientes');
    }
    
    /**
     * Editamos un registro, para luego comprobar que se han grabado correctamente
     */
    private function testEditComuni() {
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
        // editamos
        $this->model->editComunidad($esperado);
        // comprobamos
        $comunidades = $this->model->getComunidades();
        $total = $this->model->getTotal();
        
        assertArrayEquals($esperado, $comunidades, 'Test - Editar Comunidad');
       assertEquals(3, $total, 'Test número comunidades - Editar Comunidad');
        
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
    /**
     * Añadimos un registro y comprobamos que se ha añadido
     */
    private function testAddComuni() : int {
        
        // Al añadir no hay presidente ni vicepresidente
        $esperado = new stdClass();        
        $esperado->nombre = 'RESIDENCIAL AMAPOLA NUEVA';
        $esperado->calle = 'C/AMAPOLA 28 NUEVA';
        $esperado->cp = '11271';
        $esperado->poblacion = 'ALGECIRAS NUEVA';
        $esperado->presupuesto = 10000;
        $esperado->tipo_cuota = 'VARIABLE';
        $esperado->presidente = null;
        $esperado->vicepresidente = null;
        $esperado->iban = null;
        // añadimos
        $this->model->addComunidad($esperado);
        $esperado->cod = $this->model->lastId();
        // comprobamos
        $comunidades = $this->model->getComunidades();
        $total = $this->model->getTotal();
        
        assertArrayEquals($esperado, $comunidades, 'Test - Alta Comunidad');
        assertEquals(4, $total, 'Test número comunidades - Alta Comunidad');
        return $esperado->cod;
    }
    
    /*
     * Borramos la comunidad
     */
    private function testDeleteComuni(int $id) {
        // Borramos
        $this->model->borrarComunidad($id);
        // Comprobamos que está borrada la comunidad
        assertEquals(0, $this->model->getComunidad($id), 'Test - Borrar Comunidad');
    }
}
