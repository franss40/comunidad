<!DOCTYPE HTML>
<html lang="es">
    <head>    
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">        
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/purecss@2.0.6/build/grids-responsive-min.css" />

        <link rel="stylesheet" type="text/css" href="<?= URLROOT . '/public/css/style.css' ?>" />
        <title>Comunidades</title>

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
                        <h1>COMUNIDADES</h1>
                        <h3>Total: <?= $total ?></h3>
                    </div>
                </div>


                <h3 class="pure-right">
                    <a href="" class="is-warning btnNuevo">Crear Comunidad</a>
                </h3>

                <br>

                
                <table class="pure-table table-responsive">
                    <thead>
                        <tr>
                            <th>COD <br> COMUNIDAD</th>
                            <th>DIRECCION <br> POBLACION</th>
                            <th><br>IMPORTES PTES/CUOTAS</th>
                            <th><br>OPERACION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comunidades as $comunidad): ?>
                            <tr>
                                <td><?= $comunidad->cod ?><br><?= $comunidad->nombre ?></td>
                                <td><?= $comunidad->calle ?> <br> <?= $comunidad->poblacion ?></td>
                                <td><?= $comunidad->suma ?></td>
                                <td>
                                    <a href="<?= URLROOT . '/propiedades/comunidad/' . $comunidad->cod ?>" class="pure-button button-small button-success">
                                        Propiedades
                                    </a>
                                </td>
                            </tr>  
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <br><br>  
                
                
                
                

                
                <section class="pure-g is-grey">
                    <article class="pure-u-1-4">
                        <h4>COD <br> COMUNIDAD</h4>
                    </article>
                    <article class="pure-u-1-4">
                        <h4>DIRECCION <br> POBLACION</h4>
                    </article>
                    <article class="pure-u-1-4 pure-center">
                        <h4><br>IMPORTES PTES/CUOTAS</h4>
                    </article>
                    <article class="pure-u-1-4">
                        <h4><br>OPERACION</h4>
                    </article>
                </section>
                <hr>
                <?php foreach ($comunidades as $comunidad): ?>
                    <?php 
                        $rojo = '';
                        if ($comunidad->cuantos>0) {
                            $rojo = 'rojo';
                        }
                   ?>
                    <section class="pure-g <?php echo $rojo?>">
                        <article class="pure-u-1-4">
                            <?= $comunidad->cod ?><br><?= $comunidad->nombre ?>
                        </article>
                        <article class="pure-u-1-4">
                            <?= $comunidad->calle ?> <br> <?= $comunidad->poblacion ?>
                        </article>
                        <article class="pure-u-1-4 pure-center">
                            <?= $comunidad->suma ?>
                            <?php 
                                if ($comunidad->cuantos){
                                    echo '€ ('.$comunidad->cuantos.')';                                            
                                }
                            ?>
                        </article>
                        <article class="pure-u-1-4">
                            <button class="pure-button button-small pure-button-primary">
                                Entrar
                            </button>
                            <a href="<?= URLROOT . '/propiedades/comunidad/' . $comunidad->cod ?>" class="pure-button button-small button-success">
                                Propiedades
                            </a>
                            <button class="pure-button button-small button-secondary">
                                Proveedores
                            </button>
                            <button class="pure-button button-small button-error">
                                Contabilidad
                            </button>
                            <button class="pure-button button-small button-warning">
                                Nueva Publicacion
                            </button>
                        </article>
                    </section>
                    <hr> 
                <?php endforeach; ?>
                              

            </section>
        </div>
        <script type="text/javascript" src="<?= URLROOT . '/public/js/miJS.js' ?>"></script>
    </body>
</html>