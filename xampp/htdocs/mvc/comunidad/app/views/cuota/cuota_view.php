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
                    <a href="<?= URLROOT . '/usuario' ?>" class="pe-2">
                        <img src="<?= URLROOT . '/public/img/usuarios_lock.svg' ?>" width="36" height="36" alt="Usuarios" title="Usuarios"/>
                    </a>

                    <a href="<?= URLROOT . '/cerrar_sesion' ?>">
                        <img src="<?= URLROOT . '/public/img/box-arrow-right.svg' ?>" width="36" height="36" alt="Cerrar Sesión" title="Cerrar sesión"/>
                    </a>
                </div>
            </div>
        </header>
        
        <section class="container-fluid mt-2" role="informacion">
            <div class="row">
                <div class="col-md-6 bg-info text-black text-center p-2">
                    Comunidad: <?=$codComunidad?>
                </div>   
                <div class="col-md-6 bg-success text-white text-center p-2">
                    Propiedad : <?= $propiedad ?>
                </div>
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
                        <strong><a href="<?= URLROOT . '/propiedad/comunidad/' .$codComunidad ?>">Propietario</a></strong>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <strong>Cuotas</strong>
                    </li>
                </ol>
            </nav>
            <hr>
        </div>

        <section class="container">
            <section class="mt-4" role="main">
                <div class="ps-3 btn-group">                
                    <a href="<?= URLROOT . '/cuota/nuevo' ?>" type="button" class="btn btn-success">                           <img src="<?= URLROOT . '/public/img/file-plus.svg' ?>" width="25" height="25" alt="Adicionar Usuario" title="Nuevo Usuario"/>
                        Crear Cuota
                    </a>
                </div> 
            </section>
        
            
            <?php if ($total!=0):?>
                <br><br>
                <div class="table-responsive-md ps-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">RECIBO</th>
                            <th scope="col">CONCEPTO</th>
                            <th scope="col">IMPORTE</th>
                            <th scope="col">ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        <?php foreach ($cuotas as $cuota): ?>
                        <tr class="<?= $cuotaPendiente ?>">
                            <th scope="row">
                                <?= $cuota->recibo_com ?>                               
                            </th>
                            <td>
                                <?= $cuota->concepto ?> 
                            </td>
                            <td>
                                <?= $cuota->importe ?> €
                            </td>
                            <td>
                                <?= $cuota->estado ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>                        
                    </tbody>
                </table>
            <div>
            <?php else:?>
                <br> <br> 
                <p class="h4 alert alert-danger ps-2 text-center" role="alert">
                    No tiene actualmente ningun recibo dado de alta
                </p>
            <?php endif;?>
        </section>   
            
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
        <script>  
            window.onload = function() {
                var borrar = document.querySelectorAll('a.borrar');  
                
                for (var i = 0; i < borrar.length; i++) {  
                    borrar[i].addEventListener('click', function(event) {
                        var info = "¿Estas seguro que deseas borrar el usuario " + this.getAttribute('rel') + "? Los cambios no podrán deshacerse";
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