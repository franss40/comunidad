<?php
/**
 * Pruebas del módulo Cuotas
 *
 * @author Fco Sanz
 */
class PruebatestCuota extends Controller {
    /**
     * Cargamos los modelos
     */
    public function __construct() {
        $this->setModel('Cuotas');
        $this->addModel('Propiedades');
        $this->addModel('Comunidades');
        $this->index();
    }
    
    /**
     * Aquí hacemos los test de todos los casos de uso (CU); uno por uno
     */
    private function index() {
        $this->testListCuotas(); // CU Consultar Cuotas
        $this->testAddCuotas();  // CU Alta Cuotas
        $this->testPendientesCuotas(); // CU Cuotas Pendientes
        $this->testCambiarEstadoCuota(); // CU Cambiar Estado Cuota
        $this->testActualizarCuotas(); // CU Actualizar Cuotas
    }
    
    /*
     * Test listar cuotas de una determinada propiedad
     */
    private function testListCuotas() {
        // RECUPERAMOS DATOS
        $cuotas = $this->model->getCuotas(1, 'PRIMERO A');
        $total = $this->model->getTotal();
        
        $esperado = new stdClass();
        $esperado->recibo_com = 4;
        $esperado->cod = 1;
        $esperado->numero = 'PRIMERO A';
        $esperado->fecha_recibo = '2021-01-01';
        $esperado->fecha_pago = '2021-01-01';
        $esperado->importe = 84.5;
        $esperado->concepto = 'CUOTA COMUNIDAD ENERO 2021';
        $esperado->estado = 'PAGADO';
        
        // COMPROBAMOS
        assertArrayEquals($esperado, $cuotas, 'Test - Consultar Cuota');
        assertEquals(3, $total, 'Test número de cuotas - Consultar Cuota');
    }
    
    /*
     * Comprobamos el alta de cuotas
     */
    private function testAddCuotas() {
        // recupero cuotas pendientes
        $pendiente = $this->models['Comunidades']->getComuConCuotasPte(1);
        $cuotasPendientes = $pendiente[0]->cuantos;    // debe salir 5
        $eurosPendientes = $pendiente[0]->suma;        // debe salir 211.30
        assertEquals(5, $cuotasPendientes, 'Test número de cuotas pendientes - Alta Cuotas');
        assertEquals(211.30, $eurosPendientes, 'Test cantidad de cuotas pendientes - Alta Cuotas');
        // Esta comunidade de cod 1, tiene una cuota fija de 6000 euros y hay 9 propietarios
        // Luego la cuota de cada propietario es de 6000/9/12 = 55.55 euros;
        // pero de momento no está actualizada. Hay que actualizar primero para ponerla correctamente
        // CUOTA ORDINARIA
        $esperado = new stdClass();
        $esperado->recibo_com = 0;
        $esperado->cod = 1;
        $esperado->ano = 2022;
        $esperado->mes = 4;
        $esperado->tipoCuota = 'ORDINARIA';
        // Las siguientes son las propiedades que han pagado; el resto son impagadas
        $esperado->propiedad = array('BAJO A', 'BAJO B', 'PRIMERO B');
        //recupero las propiedades de la comunidad
        $propiedades = $this->models['Propiedades']->getPropiedades(1);
        // creamos las cuotas para todos los propietarios
        $this->model->crearCuota($propiedades, $esperado);
        
        // Inicialmente y tenemos 5 cuotas pendientes de cobro con 211.30 euros
        // Cuando realizamos esto; como son 9 propietarios y 3 pagan, hay 6 que no
        // 5 + 6 = 11 cuotas pendientes actualmente con un total de 538.80(las he sumado)
        $pendiente2 = $this->models['Comunidades']->getComuConCuotasPte(1);
        $cuotasPendientes2 = $pendiente2[0]->cuantos;    // debe salir 11
        $eurosPendientes2 = $pendiente2[0]->suma;        // debe salir 538.80
        assertEquals(11, $cuotasPendientes2, 'Test número de cuotas pendientes 2 - Alta Cuotas');
        assertEquals(538.80, $eurosPendientes2, 'Test cantidad de cuotas pendientes 2 - Alta Cuotas');
    }
    /*
     * Cuotas pendientes
     */
    private function testPendientesCuotas() {
        $cuotas = $this->model->getCuotasPendientes(1, 'GARAJE 1');
        $total = $this->model->getTotal();
        
        $esperado = new stdClass();
        $esperado->recibo_com = 18;
        $esperado->cod = 1;
        $esperado->numero = 'GARAJE 1';
        $esperado->fecha_recibo = '2021-02-01';
        $esperado->fecha_pago = null;
        $esperado->importe = 14.10;
        $esperado->concepto = 'CUOTA COMUNIDAD FEBRERO 2021';
        $esperado->estado = 'IMPAGADO';
        // COMPROBAMOS
        assertArrayEquals($esperado, $cuotas, 'Test - Cuotas Pendientes');
        assertEquals(4, $total, 'Test número de cuotas pendientes - Cuotas Pendientes');
    }
    
    /*
     * Cambiar estado de cuotas
     */
    private function testCambiarEstadoCuota() {
        // cambio estado del número 4, que está como pagada, la pongo en impagada y nos
        // deberá salir en las cuotas impagadas
        $this->model->cambiarEstadoCuota(4);
        
        $cuotas = $this->model->getCuotasPendientes(1, 'PRIMERO A');
        
        $esperado = new stdClass();
        $esperado->recibo_com = 4;
        $esperado->cod = 1;
        $esperado->numero = 'PRIMERO A';
        $esperado->fecha_recibo = '2021-01-01';
        $esperado->fecha_pago = null;
        $esperado->importe = 84.50;
        $esperado->concepto = 'CUOTA COMUNIDAD ENERO 2021';
        $esperado->estado = 'IMPAGADO';

        // COMPROBAMOS
        assertArrayEquals($esperado, $cuotas, 'Test - Cambiar Estado Cuota');
    }
    
    /*
     * Test Actualizar Cuota Comunidad
     */
    private function testActualizarCuotas() {
        // ACTUALIZO
        require_once APPROOT.'/controllers/'.'Comunidad.php';
        $comunidad = new Comunidad();
        $comunidad->actualizarCuota(1, true);
        
        // recupero las propiedades de la comunidad para la comprobación
        // Al ser la cuota de tipo fija de 6000 euros, se dividen entre los números propietarios
        // 6000/12/9 = 55.56 euros
        $propiedades = $this->models['Propiedades']->getPropiedades(1);

        $error = true;
        foreach ($propiedades as $propiedad) {
            if ($propiedad->cuota!=55.56) {
                $error = false;
            }            
        }
        assertEquals($error, true, 'Test con cuotas fijas - Actualizar Cuotas');
        //Probamos con la comunidad número 3, que tiene presupuesto 10500 euros variables
        // Por ejemplo el 1-C  tiene una participación de 10.56, por lo que su cuota es 92.4
        // Y 2-C con 14.08 de participación tiene una cuota de 123.20 (14.08*10500/100/12)
        $comunidad->actualizarCuota(3, true);
        $propiedades2 = $this->models['Propiedades']->getPropiedades(3);

        $error2 = true;
        foreach ($propiedades2 as $propiedad) {
            if ($propiedad->numero == '1-C' && $propiedad->cuota != 92.40) {
                $error2 = false;
            }       
            if ($propiedad->numero == '2-C' && $propiedad->cuota != 123.20) {
                $error2 = false;
            }
        }
        assertEquals($error2, true, 'Test con cuotas variables- Actualizar Cuotas');
    }
}
