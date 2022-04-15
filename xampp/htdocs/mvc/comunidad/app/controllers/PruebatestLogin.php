<?php
/**
 * Test de Login
 *
 * @author Fco Sanz
 */
class PruebatestLogin extends Controller{
    /**
     * Cargamos los modelos
     */
    public function __construct() {
        $this->setModel('Logins');
        $this->index();
    }
    
    /**
     * Aquí hacemos los test de todos los casos de uso (CU); uno por uno
     */
    private function index() {
        $this->testComprobarLogin(); // CU Comprobar Login
    }
    
    /*
     * Prueba comprobar Login
     */
    private function testComprobarLogin() {
        $esperado = new stdClass();
        $esperado->email_usuario = 'admin@comuni.com';
        $esperado->usuario = 'admin';
        $esperado->password = '$2y$10$qWiYbtigYF6FtXWJPC.nDuNUFEWBBR8Ypej4CngFUYY.FBvqjiZK6';
        $esperado->activo = true;
        $esperado->tipo = 'ADMIN';
        
        $person = $this->model->verifyPass('admin', 'admin');
        assertArrayEquals($esperado, $person, 'Test - Comprobar Login');
    }
}
