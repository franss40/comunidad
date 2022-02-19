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

        <!--
        <link rel="stylesheet" type="text/css" href="<?= URLROOT . '/public/css/style.css' ?>" />
        -->

    </head>

    <body>        
        
        <div class="container-fluid pt-3">
            <div class="row">
                <div class="col-2"><h1>COMUNI</h1></div>
                <div class="col-10 text-end">Cerrar Sesión</div>
            </div>
        </div>
       
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item list-group-item-action list-group-item-info text-center active">Comunidad</li>
            <li class="list-group-item list-group-item-action text-center">Proveedor</li>
            <li class="list-group-item list-group-item-action text-center">Incidencia</li>
        </ul>
        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">COD <br> COMUNIDAD</th>
                    <th scope="col">DIRECCION <br> POBLACION</th>
                    <th scope="col"><br>IMPORTES PTES/CUOTAS</th>
                    <th scope="col"><br>OPERACION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comunidades as $comunidad): ?>
                <?php 
                    $rojo = '';
                    if ($comunidad->cuantos>0) {
                        $rojo = 'rojo';
                    }
                ?>
                <tr <?php echo $rojo?>>
                    <th scope="row"><?= $comunidad->cod ?><br><?= $comunidad->nombre ?></th>
                    <td><?= $comunidad->calle ?> <br> <?= $comunidad->poblacion ?></td>
                    <td><?= $comunidad->suma ?></td>
                    <td>
                        <a href="<?= URLROOT . '/propiedades/comunidad/' . $comunidad->cod ?>" class="">
                            Propiedades
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <h3>Total: <?= $total ?></h3>
        <h3 class="pure-right">
            <a href="" class="is-warning btnNuevo">Crear Comunidad</a>
        </h3>
        
        <!--
        <script type="text/javascript" src="<?= URLROOT . '/public/js/miJS.js' ?>"></script>
        -->
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>