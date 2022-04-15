<?php
/**
 * Pruebas del módulo Propiedad
 *
 * @author Fco Sanz
 */
class PruebatestPropiedad extends Controller{
    /**
     * Cargamos los modelos
     */
    public function __construct() {
        $this->setModel('Propiedades');
        $this->index();
    }
    
    /**
     * Aquí hacemos los test de todos los casos de uso (CU); uno por uno
     */
    private function index() {
        $this->testListPropiedad(); // CU Consultar Propiedad
        $this->testAddPropiedad();  // CU Alta Propiedad
        $this->testEditPropiedad(); // CU Editar Propiedad
        $this->testDeletePropiedad(); // CU Borrar Propiedad
    }
    
    /*
     * Probamos el listado de Propiedades de la comunidad con cod 1
     */
    private function testListPropiedad() {
        $propiedades = $this->model->getPropiedades(1);
        $total = $this->model->getTotal();
        
        $esperado = new stdClass();
        $esperado->numero = 'PRIMERO A';
        $esperado->cod = 1;
        $esperado->participacion = 16.90;
        $esperado->numero_cuenta = '5546 2425 9928 8444';
        $esperado->superficie = 120;
        $esperado->email_propietario = 'OliverioVelizArana@dayrep.com';
        $esperado->cuota = 84.50;
        $esperado->nombre_propietario = 'Oliverio Veliz Arana';
        $esperado->tf_propietario = '668 270 838';
        $esperado->nombre_inquilino = 'Habid Malave Nazario';
        $esperado->tf_inquilino = '780 230 585';
        $esperado->tipo_prop = 'VIVIENDA';
        
        assertArrayEquals($esperado, $propiedades, 'Test - Consultar Propiedad');
        assertEquals(9, $total, 'Test número de propiedades - Consultar Propiedad');
    }
    
    /*
     * Probamos el add de Propiedades de la comunidad con cod 1
     */
    private function testAddPropiedad() {
        $esperado = new stdClass();
        $esperado->numero = 'PRIMERO AAA';
        $esperado->cod = 1;
        $esperado->participacion = 18.1;
        $esperado->numero_cuenta = '4444';
        $esperado->superficie = 210;
        $esperado->email_propietario = 'feliz@google.com';
        $esperado->cuota = 60;
        $esperado->nombre_propietario = 'Feliz';
        $esperado->tf_propietario = '888 888 888';
        $esperado->nombre_inquilino = 'Feliz';
        $esperado->tf_inquilino = '777 777 777';
        $esperado->tipo_prop = 'OFICINA';
        // añadimos
        $this->model->addPropiedad($esperado);
        // Comprobamos
        $propiedades = $this->model->getPropiedades(1);
        $total = $this->model->getTotal();
        assertArrayEquals($esperado, $propiedades, 'Test - Alta Propiedad'); 
        assertEquals(10, $total, 'Test número de propietarios - Alta Propiedad');
    }
    
    /*
     * Probamos el Editar de propiedad
     * No se puede editar ni el código comunidad ni número vivienda por ser claves principales
     */
    private function testEditPropiedad() {
        $esperado = new stdClass();
        $esperado->numero = 'PRIMERO AAA';
        $esperado->cod = 1;
        $esperado->participacion = 18.5;
        $esperado->numero_cuenta = '3333';
        $esperado->superficie = 220;
        $esperado->email_propietario = 'felices@google.com';
        $esperado->cuota = 30;
        $esperado->nombre_propietario = 'Felices';
        $esperado->tf_propietario = '111 111 111 111';
        $esperado->nombre_inquilino = 'Felices';
        $esperado->tf_inquilino = '777 777 778';
        $esperado->tipo_prop = 'VIVIENDA';
        // EDITAMOS
        $this->model->editPropiedad($esperado);

        // COMPROBAMOS
        $propiedades = $this->model->getPropiedades(1);
        $total = $this->model->getTotal();
        assertArrayEquals($esperado, $propiedades, 'Test - Editar Propiedad');
        assertEquals(10, $total, 'Test número de propietarios - Editar Propiedad');
    }
    
    /*
     * Probamos Borrar la propiedad recien añadida y editada posteriormente 
     */
    private function testDeletePropiedad() {
        // BORRAMOS
        $this->model->borrarPropiedad(1, 'PRIMERO AAA');
        // COMPROBAMOS
        $propiedad = $this->model->getPropiedad(1,'PRIMERO AAA');
        $this->model->getPropiedades(1);
        $total = $this->model->getTotal();
        assertEquals(0, $propiedad, 'Test - Borrar Propiedad');
        assertEquals(9, $total, 'Test número de propietarios - Borrar Propiedad');
    }
}
