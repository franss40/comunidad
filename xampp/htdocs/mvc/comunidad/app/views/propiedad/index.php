<!DOCTYPE HTML>
<html lang="es">
    <head>    
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">        
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/purecss@2.0.6/build/grids-responsive-min.css" />
        <link rel="stylesheet" type="text/css" href="<?= URLROOT . '/public/css/style.css' ?>" />
        
        <title>Propiedades</title>
    </head>
        
    <body>        
        <div class="pure-g">
            <!-- Lateral que se muestra cuando se hace click en el Menú openNav -->
            <aside class="pure-u-1" id="sideNav">  
                <!-- Cierre Menú -->
                <a href="javascript:void()" id="closeNav">&times;</a>
                <h1 class="brand">MICOMU</h1>
                
                <div class="content">
                    <a href="#">About</a>
                    <a href="#">Services</a>
                    <a href="#">Clients</a>
                    <a href="#">Contact</a>
                </div>
            </aside>
            
            <!-- Menú de contenido -->    
            <section class="pure-u-1" id="main">
                <section class="pure-g">
                    <div class="pure-u-1-2 pure-left">
                        <!-- Apertura Menú-->
                        <a href="javascript:void()" id="openNav">&#9776;</a>
                    </div>
                    <div class="pure-u-1-2 pure-right">
                        <br>
                        <a href="">
                            <b>Cerrar Sesión</b><br>  
                            <b>USUARIO</b>
                        </a>
                    </div>
                </section>
                
                <br><br>
                
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
        <script type="text/javascript" src="<?= URLROOT . '/public/js/miJS.js' ?>"></script>
    </body>
</html>