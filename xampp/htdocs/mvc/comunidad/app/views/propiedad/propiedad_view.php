<!DOCTYPE HTML>
<html lang="es">
    <head>    
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
                    <a href="<?= URLROOT . '/usuario' ?>" class="pe-2">
                        <img src="<?= URLROOT . '/public/img/usuarios_lock.svg' ?>" width="36" height="36" alt="Usuarios" title="Usuarios"/>
                    </a>

                    <a href="<?= URLROOT . '/cerrar_sesion' ?>">
                        <img src="<?= URLROOT . '/public/img/box-arrow-right.svg' ?>" width="36" height="36" alt="Cerrar Sesión" title="Cerrar sesión"/>
                    </a>
                </div>
            </div>
        </header>
        
        <section class="container-fluid mt-2" role="info">
            <div class="row">
                <div class="col-md-6 bg-info text-black text-center p-2"><?=$comunidad->nombre;?></div>
                <div class="col-md-6 bg-success text-white text-center p-2">Propiedades : <?= $total ?></div>
            </div>
        </section>
        
        <br>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        Usted está en: <strong><a href="<?= URLROOT . '/comunidad' ?>">Origen</a></strong>
                    </li>                
                    <li class="breadcrumb-item active" aria-current="page">
                        <strong>Propiedades</strong>
                    </li>
                </ol>
            </nav>
        </div>
        <hr>  
        <div class="container">
        <section class="mt-4" role="datos">
            <div class="ps-3 btn-group">                
                <a href="<?= URLROOT . '/propiedad/nueva/' . $comunidad->cod . '/'. urlAmigable($comunidad->nombre) ?>" type="button" class="btn btn-success">                           
                    <img src="<?= URLROOT . '/public/img/file-plus.svg' ?>" width="25" height="25" alt="Adicionar Propiedad" title="Nueva Propiedad"/>
                    Crear Propietario
                </a>
            </div>

            <?php if ($total!=0):?>
            
            <div class="ps-3 btn-group">                
                <a href="<?= URLROOT.'/cuota/crearCuotas/'.$comunidad->cod.'/'. urlAmigable($comunidad->nombre) ?>" type="button" class="btn btn-warning">                           
                    <img src="<?= URLROOT . '/public/img/file-plus.svg' ?>" width="25" height="25" alt="Crear Cuota" title="Crear Cuota"/>
                    Crear Cuotas
                </a>
            </div>
            
            <div class="ps-3 btn-group m-2">                
                <a href="<?= URLROOT.'/comunidad/actualizarCuota/'.$comunidad->cod ?>" type="button" class="btn btn-info" id="actualizarCuotas">
                    <img src="<?= URLROOT . '/public/img/ajustar.svg' ?>" width="25" height="25" alt="Actualizar Cuotas" title="Actualizar cuotas"/>
                    Actulizar Cuotas
                </a>
            </div>
            <br><br>
            <div class="table-responsive-md ps-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">VIVIENDA</th>
                            <th scope="col">NOMBRE INQUILINO</th>
                            <th scope="col">CUOTA MENSUAL</th>
                            <th scope="col">OPERACIÓN</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        <?php foreach ($propiedades as $propiedad): ?>
                        <tr class="<?= $cuotaPendiente ?>">
                            <th scope="row">
                                <?= $propiedad->numero ?>                               
                            </th>
                            <td>
                                <?= $propiedad->nombre_inquilino ?> 
                            </td>
                            <td>
                                <?= $propiedad->cuota ?> €
                            </td>
                            <td>
                                <a href="<?=URLROOT.'/cuota/ver/'.$comunidad->cod.'/'. urlAmigable($comunidad->nombre) .'/'. urlAmigable($propiedad->numero) ?>" type="button" class="btn btn-info mb-1">  
                                    <img src="<?= URLROOT . '/public/img/euro.svg' ?>" width="20" height="20" alt="Cuotas propietarios" title="Cuotas Propietarios"/>                                        
                                </a>
                                <a href="<?= URLROOT.'/propiedad/editar/'.$comunidad->cod.'/'.urlAmigable($comunidad->nombre).'/'. urlAmigable($propiedad->numero) ?>" type="button" class="btn btn-success mb-1">              
                                    <img src="<?= URLROOT . '/public/img/info.svg' ?>" width="20" height="20" alt="Ver o editar propiedad" title="Ver datos o editar propiedad"/>
                                </a>
                                <a href="<?= URLROOT . '/propiedad/borrar/' . $comunidad->cod . '/'. urlAmigable($comunidad->nombre).'/'. urlAmigable($propiedad->numero) ?>" type="button" class="borrar btn btn-warning mb-1" rel="<?=urlAmigable($propiedad->numero) ?>">
                                    <img src="<?= URLROOT . '/public/img/borrar.svg' ?>" width="20" height="20" alt="Borrar propiedad" title="Borrar propiedad"/>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>                        
                    </tbody>
                </table>
            <div>
                <?php else:?>
                    <br> <br> 
                    <p class="h4 alert alert-danger ps-2 text-center" role="alert">
                        No tiene actualmente ninguna propiedad dada de alta
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
                        var info = "¿Estas seguro que deseas borrar la propiedad " + this.getAttribute('rel') + "? Los cambios no podrán deshacerse";
                        if (!window.confirm(info)) {  
                            event.preventDefault();
                            return false;
                        }
                    }, false);
                };
                
                var actualizar = document.querySelector('#actualizarCuotas');
                actualizar.addEventListener('click', function(event) {
                    var info2 = "¿Estás seguro de querer actualizar todas las cuotas de esta comunidad?";
                    if (!window.confirm(info2)) {  
                        event.preventDefault();
                        return false;
                    }
                }, false);
            };
        </script>
    </body>
</html>