<?php
/**
 * Pruebas del módulo Propiedad
 *
 * @author Fco Sanz
 */
class PruebatestPropiedad {
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
        $propiedadAdd = $this->testAddPropiedad();  // CU Alta Propiedad
        $propiedadEdit = $this->testEditPropiedad($propiedadAdd); // CU Editar Propiedad
        $this->testDeletePropiedad($propiedadEdit); // CU Borrar Propiedad
    }
    
    
}
