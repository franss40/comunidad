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
            $comunidad = deleteUrlAmigable($nombreComunidad);
            $data = ['result' => "Comunidad $comunidad borrada",
                     'info' => 'Borrado Comunidad'];
        }
        $this->render('informacion_view', $data);
    }
    
    /**
     * Alta de la comunidad. Al dar el alta no se añade
     * presidente ni vicepresidente, ya que no hay aún propiedades
     * 
     */
    public function nueva() {
        
        $data = ['info' => 'Alta Comunidad',
            'token' => $_SESSION['token']
        ];
        // En el caso que haya envío de datos Post, recuperamos los datos de
        // manera segura
        $filtroPost = $this->filtrarPost();
        
        // No se comprueba la cuota por comprobarse dentro de forma segura
        if (!empty($filtroPost->nombre) && !empty($filtroPost->direccion) && !empty($filtroPost->poblacion) && !empty($filtroPost->presupuesto) && $filtroPost->token == $_SESSION['token']) {

            if ($filtroPost->tipoCuota!=='FIJA' && $filtroPost->tipoCuota!=='VARIABLE' || !is_int($filtroPost->codigoPostal)) {  
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
                $this->render('comunidad/nuevaComunidad_view', $data);
                return;
            }

            if ($this->model->addComunidad($filtroPost)) {
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
        
        // Recupero datos post si los hay
        $filtroPost = $this->filtrarPost();
        
        if (!empty($filtroPost)) {

            if (empty($filtroPost->nombre) || empty($filtroPost->direccion) || empty($filtroPost->poblacion) || empty($filtroPost->codigoPostal) || $filtroPost->token !== $_SESSION['token']) {
                $this->editMostrarSalida($cod, 'Se ha producido un error. Pruebe más tarde');
            }

            if ($filtroPost->tipoCuota!=='FIJA' && $filtroPost->tipoCuota!=='VARIABLE') {
                $this->editMostrarSalida($cod, 'Se ha producido un error. Pruebe más tarde');
            }

            if ($filtroPost->presidente!='' && $filtroPost->vicepresidente!='' && $filtroPost->presidente==$filtroPost->vicepresidente) {
                $this->editMostrarSalida($cod, 'Se ha producido un error. Pruebe más tarde');
            }

            if ($filtroPost->presidente == '') {
                $filtroPost->presidente = null;
            }

            if ($filtroPost->vicepresidente == '') {
                $filtroPost->vicepresidente = null;
            }
        
            if ($this->model->editComunidad($filtroPost)) {
                $this->editMostrarSalida($cod, 'Registro actualizado correctamente');
            } else {
                $this->editMostrarSalida($cod, 'Se ha producido un error. Pruebe más tarde de nuevo');
            }
        } else {
            $this->editMostrarSalida($cod, 'Editar Comunidad');
        }
    }
    
    /**
     * Muestro la pantalla de editar Comunidad con la información indicada
     * 
     * @param int $cod
     * @param string $info
     */
    private function editMostrarSalida($cod, $info) {
        $propiedades = $this->models['Propiedades']->getPropiedades($cod);
        $data = [
            'propiedad' => $propiedades,
            'comunidad' => $this->model->getComunidad($cod),
            'info'      => $info,
            'token' => $_SESSION['token']
        ];
        $this->render('comunidad/editarComunidad_view', $data);
    }
    
    /**
     * Filtrar datos de la comunidad. Retorno null si no hay datos post
     * 
     * @return array
     */
    private function filtrarPost() {
        $cod = filter_input(INPUT_POST, 'cod', FILTER_SANITIZE_NUMBER_INT);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRIPPED);
        $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRIPPED);
        $poblacion = filter_input(INPUT_POST, 'poblacion', FILTER_SANITIZE_STRIPPED);
        $codigoPostal = filter_input(INPUT_POST, 'codigoPostal', FILTER_VALIDATE_INT);
        $tipoCuota = filter_input(INPUT_POST, 'tipoCuota', FILTER_SANITIZE_STRIPPED);
        $presupuesto = filter_input(INPUT_POST, 'presupuesto', FILTER_VALIDATE_FLOAT);
        $presidente = filter_input(INPUT_POST, 'presidente', FILTER_SANITIZE_STRIPPED);
        $vicepresidente = filter_input(INPUT_POST, 'vicepresidente', FILTER_SANITIZE_STRIPPED);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRIPPED);
        
        $comunidad = new stdClass();
        $comunidad->cod = $cod; $comunidad->nombre = $nombre;
        $comunidad->direccion = $direccion; $comunidad->codigoPostal = $codigoPostal;
        $comunidad->poblacion = $poblacion; $comunidad->presupuesto = $presupuesto;
        $comunidad->tipoCuota = $tipoCuota; $comunidad->presidente = $presidente;
        $comunidad->vicepresidente = $vicepresidente; $comunidad->token = $token;

        if (empty($direccion) || empty($poblacion) || empty($codigoPostal) || empty($presupuesto)) {
            $comunidad = null;
        }
        return $comunidad;
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
        try {
            $comunidad = $this->model->getComunidad($codComunidad);
            $this->_existeVista($comunidad);

            $propiedades = $this->models['Propiedades']->getPropiedades($codComunidad);
            $this->_existeVista($propiedades);
            
            $numeroPropiedades = $this->models['Propiedades']->getTotal();
            // comienzo la transacción
            $this->models['Propiedades']->beginT();

            foreach ($propiedades as $propiedad) {                
                $valor = $this->_calculoValorCuota($comunidad, $propiedad, $numeroPropiedades);
                $result = $this->models['Propiedades']->actualizarCuota($comunidad->cod, $propiedad->numero, $valor);                
                // Si se produce un error en cualquiera de las actualizaciones, volvemos al principio
                if (!$result) {throw new Exception;}
            }
            $this->models['Propiedades']->endT();

        } catch (Exception $ex) {            
            $this->models['Propiedades']->backT();
            echo $ex;
            $this->_existeVista(null);
        }
        
        $data = ['info'   => 'Actualización de cuotas', 'result' => "Se ha actualizado correctamente"];
        $this->render('informacion_view', $data);
    }
    
    /**
     * Método privado que comprueba si el array pasado existe y no contiene nada
     * Si es nulo o no contiene nada mostramos la información de error
     * 
     * @param array $param
     */
    private function _existeVista($param) {
        if(empty($param)){
            $data = [
                'info'   => 'Actualización de cuotas',
                'result' => "No se ha podido actualizar las cuotas"
            ];
            $this->render('informacion_view', $data);            
        }        
    }
    
    /**
     * Calcula el valor de la cuota mensual de la comunidad
     * 
     * @param array $comunidad
     * @param array $propiedad
     * @param int $totalPropietario
     * @return float
     */
    private function _calculoValorCuota($comunidad, $propiedad, $totalPropietario) {
        if ($comunidad->tipo_cuota == 'FIJA'){
            (float)$valor = $comunidad->presupuesto / $totalPropietario;
        } else {
            (float)$valor = $propiedad->participacion * $comunidad->presupuesto / 100;
        }
        return $valor/12;
    }
}
