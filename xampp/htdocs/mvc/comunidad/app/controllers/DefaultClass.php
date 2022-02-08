<?php

class DefaultClass extends Controller
{    
    function __construct()
    {
        //Activo el modelo correspondiente
        $this->addModel('Comunidad');
    }
    
    public function index()
    {
        $comunidades = $this->model->getComunidades();
        $total = $this->model->getTotal();
        
        $data = ['comunidades' => $comunidades,
                 'total'          => $total];
        
        $this->render('Comunidad/index',$data);
        
    }

}