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
            .cuotasPendientes{ color: blue;}
        </style>
        <!-- Bootstrap css-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
        
    <body>
        <header class="mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-2">
                        <h1>
                            <img src="<?= URLROOT . '/public/img/building.svg' ?>" width="36" height="36" alt="comunidad"/>       
                            COMUNI
                        </h1>
                    </div>
                    <div class="col-10 text-end pt-2 pe-4">
                        <a href="<?= URLROOT . '/usuarios' ?>" class="pe-2">
                            <img src="<?= URLROOT . '/public/img/usuarios_lock.svg' ?>" width="36" height="36" alt="Usuarios" title="Usuarios"/>
                        </a>
                        
                        <a href="<?= URLROOT . '/cerrar_sesion' ?>">
                            <img src="<?= URLROOT . '/public/img/box-arrow-right.svg' ?>" width="36" height="36" alt="Cerrar Sesión" title="Cerrar sesión"/>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        
        <section class="mt-3" role="info">
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item list-group-item-action list-group-item-info text-center active">                     Propiedades
                </li>
                <li class="list-group-item list-group-item-action list-group-item-info text-center">
                    <?= $total ?>
                </li>
            </ul>
        </section>
        
        
        <div class="pure-g">
            
            <!-- Menú de contenido -->    
            <section class="pure-u-1" id="main">
                
                <div class="pure-g">
                    <div class="pure-u-1 pure-u-md-8-24 pure-u-lg-6-24 pure-box is-secondary">
                        <h1><?=$comunidad->nombre ?></h1>
                        <h3>Total: <?= $total ?></h3>
                    </div>
                </div>
                
                <h3 class="pure-right">
                    <a href="" class="is-warning btnNuevo">Crear Propiedad</a>
                    <a href="" class="is-warning btnNuevo">Cuotas Impagadas</a>
                </h3>

                <br>
                
                <section class="pure-g is-grey">
                    <article class="pure-u-1-4">
                        <h4>VIVIENDA</h4>
                    </article>
                    <article class="pure-u-1-4">
                        <h4>NOMBRE INQUILINO</h4>
                    </article>
                    <article class="pure-u-1-4 pure-center">
                        <h4>CUOTA MENSUAL</h4>
                    </article>
                    <article class="pure-u-1-4">
                        <h4>OPERACION</h4>
                    </article>
                </section>
                
                <hr>  
                <?php foreach ($propiedades as $propiedad):?>
                    <section class="pure-g">
                        <article class="pure-u-1-4">
                            <?= $propiedad->numero ?>
                        </article>
                        <article class="pure-u-1-4">
                            <?= $propiedad->nombre_inquilino ?>
                        </article>
                        <article class="pure-u-1-4 pure-center">
                            <?= $propiedad->cuota ?>
                            <?php if ($propiedad->cuota) echo ' €'?>
                        </article>
                        <article class="pure-u-1-4">
                            <a href="" class="pure-button button-small pure-button-primary">
                                Entrar
                            </a>
                            <a href="<?= URLROOT . '/propiedades/cuota/'.$comunidad->cod.'/'. urlAmigable($propiedad->numero) ?>" class="pure-button button-small button-success">
                                Ver Cuotas
                            </a>
                        </article>
                    </section>
                <hr>
                <?php endforeach;?>
            </section>
              
        </div>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
    </body>
</html>