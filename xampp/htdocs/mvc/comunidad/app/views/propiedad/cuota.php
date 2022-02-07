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
            <div class="pure-u-1 pure-box is-grey" data-ruta>
                -->  
                <a href="<?= URLROOT . '/comunidad' ?>">Comunidades</a> --> <a href="<?= URLROOT . '/propiedades/comunidad/'.$cuotas[0]->cod; ?>">Propiedades</a> --> Cuotas Comunidad  
            </div>
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
                        <h1>CUOTAS</h1>
                        <h2><?=$comuPropi->nombre ?></h2>
                        <h2><?=$propietario ?></h2>
                    </div>
                </div>
                
                <br>
                <section data-cuotaspendientes>
                <?php 
                    if (!$pendientes) {
                        echo '<h2>Esta propiedad no tiene cuotas pendientes</h2>';
                    } else {
                ?>
                    <h3>CUOTAS PENDENTES (<?= $total?>)</h3>
                <hr>
                <table class="pure-table pure-table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>NUMERO RECIBO</th>
                            <th>CONCEPTO</th>
                            <th>IMPORTE</th>
                            <th>PAGAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $cont = 0; foreach ($pendientes as $pendiente): $cont += $pendiente->importe;?>
                            <tr>
                                <td><?=$pendiente->recibo_com?></td>
                                <td><?=$pendiente->concepto?></td>
                                <td><?=$pendiente->importe?></td>
                                <td><a href="" class="pure-button button-small button-success">Pagar</a></td>
                            </tr>                        
                        <?php endforeach; ?> 
                            <tr>
                                <td></td>
                                <td><b>TOTAL</b></td>
                                <td><b><?= $cont?></b></td>
                                <td></td>
                            </tr> 
                    </tbody>
                </table>                
                <?php }?>
                </section>
                <br>
                
                <h3>ULTIMAS CUOTAS</h3>
                <hr>
                <section class="pure-g is-grey">                    
                    <article class="pure-u-1-4">
                        <h4>NUMERO RECIBO<br>FECHA PAGO</h4>
                    </article>
                    <article class="pure-u-1-4">
                        <h4><br>CONCEPTO</h4>
                    </article>
                    <article class="pure-u-1-4 pure-center">
                        <h4>ESTADO<br>IMPORTE</h4>
                    </article>                    
                    <article class="pure-u-1-4">
                        <h4><br>OPERACION</h4>
                    </article>
                </section>
                <hr>
                <?php foreach ($cuotas as $cuota): ?>
                    <section class="pure-g">
                        <article class="pure-u-1-4">
                            <?= $cuota->recibo_com ?><br><?= $cuota->fecha_pago ?>
                        </article>
                        <article class="pure-u-1-4">
                            <?= $cuota->concepto ?>
                        </article>
                        <article class="pure-u-1-4 pure-center">
                            <?= $cuota->estado ?><br>
                            <?= $cuota->importe ?>
                            <?php if ($cuota->importe) echo ' €'?>
                        </article>
                        <article class="pure-u-1-4">
                            <a href="" class="pure-button button-small pure-button-primary">
                                Entrar
                            </a>
                            <a href="" class="pure-button button-small button-success">
                                Pagado/Impagado
                            </a>
                        </article>
                    </section>
                    <hr>
                <?php endforeach; ?>   
            </section>   
        </div>
        <script type="text/javascript" src="<?= URLROOT . '/public/js/miJS.js' ?>"></script>
    </body>
</html>