<!DOCTYPE HTML>
<html lang="es">
    <head>    
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Comunidades</title>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Redressed&family=Staatliches&display=swap');
            h1 { 
                font-family: 'Redressed', cursive;
                font-family: 'Staatliches', cursive;
                color: green;
            }
        </style>
        <!-- Bootstrap css-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        
    </head>

    <body>
        <header class="container-fluid mt-3">
            <div class="row">
                <div class="col-6">
                    <h1>
                        <img src="<?= URLROOT . '/public/img/building.svg' ?>" width="36" height="36" alt="comunidad"/>       
                        COMUNI
                    </h1>
                </div>
                <div class="col-6 text-end pt-2 pe-4">
                    <a href="<?= URLROOT . '/usuarios' ?>" class="pe-2">
                        <img src="<?= URLROOT . '/public/img/usuarios_lock.svg' ?>" width="36" height="36" alt="Usuarios" title="Usuarios"/>
                    </a>

                    <a href="<?= URLROOT . '/cerrar_sesion' ?>">
                        <img src="<?= URLROOT . '/public/img/box-arrow-right.svg' ?>" width="36" height="36" alt="Cerrar Sesión" title="Cerrar sesión"/>
                    </a>
                </div>
            </div>
        </header>
        
        <section class="container-fluid mt-2">
            <div class="row">
                <div class="col-md-12 bg-info text-black text-center p-2">Comunidades: <?= $total ?></div>             </div>
        </section>
        
        <br>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        Usted está en: <strong>Origen</strong>
                    </li>
                </ol>
            </nav>
            <hr>
        </div>
        
        <div class="container container-info">
        <section class="mt-4" role="main">
            <div class="ps-3 btn-group">                
                <a href="<?= URLROOT . '/comunidad/nueva' ?>" type="button" class="btn btn-success">                           <img src="<?= URLROOT . '/public/img/file-plus.svg' ?>" width="25" height="25" alt="Adicionar Comunidad" title="Nueva Comunidad"/>
                    Crear Comunidad
                </a>
            </div> 
            <?php if ($total!=0):?>
            <div class="table-responsive-md ps-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">COD <br> COMUNIDAD</th>
                            <th scope="col">DIRECCIÓN <br> POBLACIÓN</th>
                            <th scope="col"><br>TIPO CUOTA <br> PRESUPUESTO</th>
                            <th scope="col"><br>IMPORTE PTE <br> CUOTA</th>                            
                            <th scope="col"><br>OPERACIÓN</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        <?php foreach ($comunidades as $comunidad): ?>
                            <?php
                            $rojo = '';
                            if ($comunidad->cuantos > 0) {
                                $cuotaPendiente = 'cuotasPendientes';
                            }
                            ?>
                        <tr class="<?= $cuotaPendiente ?>">
                            <th scope="row">
                                <?= $comunidad->cod ?>
                                <!-- Sólo saldrá el icono si hay alguna incidencia abierta-->
                                <?php if ($comunidad->incidencia == true):?>
                                    <img class="ms-2" src="<?= URLROOT . '/public/img/telephone.svg' ?>" width="20" height="20" alt="tiene incidencia abierta" title="Incidencia abierta"/>
                                <?php endif;?>
                                <br>
                                <?= $comunidad->nombre ?>                                
                            </th>
                            <td>
                                <?= $comunidad->calle ?> 
                                <br> <?= $comunidad->poblacion ?>
                            </td>
                            <td>
                                <?= $comunidad->tipo_cuota ?> 
                                <br> <?= $comunidad->presupuesto ?>
                            </td>
                            <td>
                                <?= $comunidad->suma ?> €
                                <br>
                                <?= $comunidad->cuantos ?>
                            </td>
                            <td>
                                <a href="<?= URLROOT . '/propiedad/comunidad/' . $comunidad->cod ?>" type="button" class="btn btn-info mb-1">  
                                    <img src="<?= URLROOT . '/public/img/people.svg' ?>" width="20" height="20" alt="Ver propietarios" title="Propietarios"/>                                        
                                </a>
                                <a href="<?= URLROOT . '/comunidad/editar/' . $comunidad->cod ?>" type="button" class="btn btn-success mb-1">              
                                    <img src="<?= URLROOT . '/public/img/pencil-square.svg' ?>" width="20" height="20" alt="Editar comunidad" title="Editar comunidad"/>
                                </a>
                                <a href="<?= URLROOT . '/comunidad/borrar/' . $comunidad->cod ?>" type="button" class="borrar btn btn-warning mb-1" rel="<?=$comunidad->nombre?>">
                                    <img src="<?= URLROOT . '/public/img/borrar.svg' ?>" width="20" height="20" alt="Borrar comunidad" title="Borrar comunidad"/>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>                
                    </tbody>
                </table>
            <div>
                <?php else:?>
                    <br> <br> 
                    <p class="h4 alert alert-danger ps-2" role="alert">
                        No tiene actualmente ninguna comunidad dada de alta
                    </p>
                <?php endif;?>
        </section>
        </div>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
        <script type="text/javascript">  
            window.onload = function() {
                var borrar = document.querySelectorAll('a.borrar');  
                
                for (var i = 0; i < borrar.length; i++) {  
                    borrar[i].addEventListener('click', function(event) {
                        var info = "¿Estas seguro que deseas borrar la comunidad " + this.getAttribute('rel') + "? Los cambios no podrán deshacerse";
                        if (!window.confirm(info)) {  
                            event.preventDefault();
                            return false;
                        }
                    }, false);
                }
            };
        </script>
    </body>
</html>