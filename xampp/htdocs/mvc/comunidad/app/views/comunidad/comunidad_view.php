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
                        <a href="">
                            <img src="<?= URLROOT . '/public/img/box-arrow-right.svg' ?>" width="36" height="36" alt="Cerrar Sesión"/>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <nav class="mt-3">
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item list-group-item-action list-group-item-info text-center active">                     Comunidades
                </li>
                <li class="list-group-item list-group-item-action list-group-item-info text-center">
                    <?= $total ?>
                </li>
            </ul>
        </nav>

        <section class="mt-5">
            <div class="ps-3 btn-group">          
                <img src="<?= URLROOT . '/public/img/file-plus.svg' ?>" width="36" height="36" alt="Adicionar Comunidad"/>
                <a href="" type="button" class="btn btn-success">                    
                    Crear Comunidad
                </a>
            </div> 
            <table class="table table-hover mt-3">
                <thead>
                    <tr>
                        <th scope="col">COD <br> COMUNIDAD</th>
                        <th scope="col">DIRECCIÓN <br> POBLACIÓN</th>
                        <th scope="col"><br>IMPORTES PTES/CUOTAS</th>
                        <th scope="col"><br>OPERACIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comunidades as $comunidad): ?>
                        <?php
                        $rojo = '';
                        if ($comunidad->cuantos > 0) {
                            $rojo = 'rojo';
                        }
                        ?>
                        <tr <?php echo $rojo ?>>
                            <th scope="row"><?= $comunidad->cod ?><br><?= $comunidad->nombre ?></th>
                            <td><?= $comunidad->calle ?> <br> <?= $comunidad->poblacion ?></td>
                            <td><?= $comunidad->suma ?></td>
                            <td>
                                <a href="<?= URLROOT . '/propiedades/comunidad/' . $comunidad->cod ?>" type="button" class="btn btn-info mb-1">                    
                                    Propietario
                                </a>
                                <a href="" type="button" class="btn btn-success mb-1">                    
                                    Ver
                                </a>
                                <a href="" type="button" class="btn btn-warning mb-1">
                                    Borrar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>    
        </section>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
    </body>
</html>