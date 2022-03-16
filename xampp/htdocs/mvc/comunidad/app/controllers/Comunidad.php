<?php

/**
 * Gestión de datos de las comunidades
 *
 * @author Fco Sanz
 */
class Comunidad extends Controller {

    public function __construct() {
        $this->setModel('Comunidades');
        $this->addModel('Incidencias');
        $this->addModel('Propiedades');
    }

    /**
     * Muestra las comunidades que existen con sus cuotas pendientes
     *  
     */
    public function index() {
        $incidencias = $this->models['Incidencias']->getIncidencias();

        $comunidades = $this->model->getComunidades();
        $total = $this->model->getTotal();

        $cuotasPendientes = $this->model->getComuConCuotasPtes();
        foreach ($comunidades as $comunidad) {
            $comunidad->cuantos = 0;
            $comunidad->suma = 0;
            foreach ($cuotasPendientes as $cuotaPendiente) {
                if ($comunidad->nombre == $cuotaPendiente->nombre) {
                    $comunidad->cuantos = $cuotaPendiente->cuantos;
                    $comunidad->suma = $cuotaPendiente->suma;
                }
            }

            $comunidad->incidencia = false;
            if ($this->comunidadTieneIncidencia($comunidad, $incidencias)) {
                $comunidad->incidencia = true;
            }
        }

        $data = ['comunidades' => $comunidades, 'total' => $total];

        $this->render('comunidad/comunidad_view', $data);
    }
    
    /**
     * Nos indica si la comunidad tiene incidencia o no
     * 
     * @param array $comunidad
     * @param array $incidencias
     * @return boolean
     */
    private function comunidadTieneIncidencia($comunidad, $incidencias) {
        foreach ($incidencias as $incidencia) {
            if ($comunidad->cod == $incidencia->cod) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Borrado de una comunidad
     * 
     * @param int $cod
     */
    public function borrar(int $cod, string $nombreComunidad) {
        $data = [
                'info' => "Borrado Comunidad",
                'result' => "Se ha producido un error al intentar borrar la comunidad $nombreComunidad"
                ];
        if ($this->model->borrarComunidad($cod)) {
            $data = ['result' => "Comunidad $nombreComunidad borrada",
                     'info' => 'Borrado Comunidad'];
        }
        $this->render('informacion_view', $data);
    }
    
    /**
     * Alta de la comunidad. Al dar el alta no se añade ni presupuesto ni
     * presidente ni vicepresidente, ya que no hay aún propiedades
     * 
     */
    public function nueva() {
        
        $data = ['info' => 'Alta Comunidad',
            'token' => $_SESSION['token']
        ];
        // En el caso que haya envío de datos Post, recuperamos los datos de
        // manera segura
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRIPPED);
        $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRIPPED);
        $codigoPostal = filter_input(INPUT_POST, 'codigoPostal', FILTER_VALIDATE_INT);
        $poblacion = filter_input(INPUT_POST, 'poblacion', FILTER_SANITIZE_STRIPPED);
        $tipoCuota = filter_input(INPUT_POST, 'tipoCuota', FILTER_SANITIZE_STRIPPED);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRIPPED);
        
        // No se comprueba la cuota ni código por comprobarse dentro de forma segura
        if (!empty($nombre) && !empty($direccion) && !empty($poblacion) && $token == $_SESSION['token']) {

            if ($tipoCuota!=='FIJA' && $tipoCuota!=='VARIABLE' || !is_int($codigoPostal)) {  
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
                $this->render('comunidad/nuevaComunidad_view', $data);
                return;
            }
            // En vez de arrays, utilizamos objetos stdclass
            $comunidad = new stdClass();
            $comunidad->nombre = $nombre; 
            $comunidad->direccion = $direccion;
            $comunidad->codigoPostal = $codigoPostal;
            $comunidad->poblacion = $poblacion;
            $comunidad->tipoCuota = $tipoCuota;
            
            if ($this->model->addComunidad($comunidad)) {
                $data['info'] = 'Registro añadido correctamente';
            } else {
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
            }      
        }

        $this->render('comunidad/nuevaComunidad_view', $data);
    }
    
    /**
     * Editar comunidad
     * 
     * @param int $cod
     */
    public function editar(int $cod) {
        
        require_once APPROOT . '/views/helpers_view.php';
        $data = ['info' => 'Editar Comunidad',
            'token' => $_SESSION['token']
        ];
        
        // En el caso que haya envío de datos Post, recuperamos los datos de
        // manera segura
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRIPPED);
        $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRIPPED);
        $poblacion = filter_input(INPUT_POST, 'poblacion', FILTER_SANITIZE_STRIPPED);
        $codigoPostal = filter_input(INPUT_POST, 'codigoPostal', FILTER_VALIDATE_INT);
        $tipoCuota = filter_input(INPUT_POST, 'tipoCuota', FILTER_SANITIZE_STRIPPED);
        $presupuesto = filter_input(INPUT_POST, 'presupuesto', FILTER_VALIDATE_FLOAT);
        $presidente = filter_input(INPUT_POST, 'presidente', FILTER_SANITIZE_STRIPPED);
        $vicepresidente = filter_input(INPUT_POST, 'vicepresidente', FILTER_SANITIZE_STRIPPED);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRIPPED);
        
        // No se comprueba la cuota por hacerlo dentro de forma segura. 
        // Tampoco lo hacemos con el presidente, vicepresidente ni presupuesto por no ser campos obligatorios
        if (!empty($nombre) && !empty($direccion) && !empty($poblacion) && $token == $_SESSION['token']) {
            if ($tipoCuota!=='FIJA' && $tipoCuota!=='VARIABLE') {  
                $propiedades = $this->models['Propiedades']->getPropiedades($cod);
                $data['propiedad'] = $propiedades;
                $data['comunidad'] = $this->model->getComunidad($cod)[0];
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
                $this->render('comunidad/editarComunidad_view', $data);
                return;
            }
            // no pueden ser la misma persona presidente y vicepresidente
            if ($presidente!='' && $vicepresidente!='' && $presidente==$vicepresidente) {
                $propiedades = $this->models['Propiedades']->getPropiedades($cod);
                $data['propiedad'] = $propiedades;
                $data['comunidad'] = $this->model->getComunidad($cod)[0];
                $data['info'] = 'No pueden ser presidente y vicepresidente la misma persona';
                $this->render('comunidad/editarComunidad_view', $data);
                return;
            }
            if ($presidente == '') {
                $presidente = null;
            }
            if ($vicepresidente == '') {
                $vicepresidente = null;
            }
            // En vez de arrays, utilizamos objetos stdclass
            $comunidad = new stdClass();
            $comunidad->cod = $cod;
            $comunidad->nombre = $nombre; 
            $comunidad->direccion = $direccion;
            $comunidad->codigoPostal = $codigoPostal;
            $comunidad->poblacion = $poblacion;
            $comunidad->presupuesto = $presupuesto;
            $comunidad->tipoCuota = $tipoCuota;
            $comunidad->presidente = $presidente;
            $comunidad->vicepresidente = $vicepresidente;

            if ($this->model->editComunidad($comunidad)) {
                $data['info'] = 'Registro actualizado correctamente';
            } else {
                $data['info'] = 'Se ha producido un error. Pruebe más tarde de nuevo';
            }
        }
        
        $propiedades = $this->models['Propiedades']->getPropiedades($cod);
        $data['propiedad'] = $propiedades;
        $data['comunidad'] = $this->model->getComunidad($cod);
        $this->render('comunidad/editarComunidad_view', $data);
    }
    
    /**
     * Recalculamos las cuotas de todos los propietarios
     * 
     * primero conectamos con la comunidad para ver el tipo de cuota y el presupuesto
     * seguidamente si es cuota fija tenemos que saber el número de propiedades para calcularla
     * Si no es así necesitamos el presupuesto
     * Recorremos todas las propiedades calculando la cuota en cada una 
     * 
     * @param int $codComunidad
     */
    public function actualizarCuota(int $codComunidad) {
        $data = [
                'info'   => 'Actualización de cuotas',
                'result' => "Se ha actualizado correctamente"
                ];
        
        $comunidad = $this->model->getComunidad($codComunidad);
        if(empty($comunidad)){
            $data = [
                'info'   => 'Actualización de cuotas',
                'result' => "No se ha podido actualizar las cuotas"
            ];
        }
        $propiedades = $this->models['Propiedades']->getPropiedades($codComunidad);
        $numeroPropiedades = $this->models['Propiedades']->getTotal();
        
        if ($comunidad->tipo_cuota == 'FIJA'){
            foreach ($propiedades as $propiedad) {
                (float)$valor = $comunidad->presupuesto / $numeroPropiedades;
                $result = $this->models['Propiedades']->actualizarCuota($comunidad->cod, $propiedad->numero, $valor);
                if (!$result) {
                    $data = [
                        'info'   => 'Actualización de cuotas',
                        'result' => "No se ha podido actualizar las cuotas"
                    ];
                }
            }
        } else {
            foreach ($propiedades as $propiedad) {
                (float)$valor = $propiedad->participacion * $comunidad->presupuesto / 100;

                $result = $this->models['Propiedades']->actualizarCuota($comunidad->cod, $propiedad->numero, $valor);
                if (!$result) {
                    $data = [
                        'info'   => 'Actualización de cuotas',
                        'result' => "No se ha podido actualizar las cuotas"
                    ];
                }
            }
        }

        $this->render('informacion_view', $data);
    }
}
