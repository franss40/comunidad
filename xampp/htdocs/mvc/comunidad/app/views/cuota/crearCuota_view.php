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
        
        <div class="container-fluid mt-2">
            <div class="row">
                <div class="col-md-12 bg-info text-black text-center p-2">
                    <?=$info?>
                </div>              
            </div>
        </div>
        
        <br>
        <div class="container">
            <nav aria-label="breadcrumb" class="mt-2 ps-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        Usted está en: <strong><a href="<?= URLROOT . '/comunidad' ?>">Origen</a></strong>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <strong><a href="<?= URLROOT . '/propiedad/comunidad/'.$codComunidad ?>">Propiedades</a></strong>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <strong>Alta Cuotas</strong>
                    </li>
                </ol>
            </nav>
            <hr>
        </div>
        
        
        <section class="mt-4" role="main">            
            <div class="container bg-light p-3">
                <form action="" method="POST">
                    <input type="hidden" name="token" class="form-control" value="<?=$token ?>">
                    <div class="row mb-3">
                        <div class="col-sm-7">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" name="fecha" class="form-control" id="fecha" required autofocus>
                        </div>
                        <div class="col-sm-7 mt-3">
                            <label for="concepto" class="form-label">Concepto</label>
                            <input type="text" name="concepto" class="form-control text-end" id="concepto">
                        </div>
                        <div class="col-sm-5 mt-3">
                            <label for="importe" class="form-label">Importe</label>
                            <input type="text" name="importe" class="form-control" id="importe" required>
                        </div>                        
                    </div>
                    <p><strong>Deselecciona los propietarios que aún no han pagado</strong></p>
                    <div class="row mb-3">
                        <?php foreach ($propiedades as $propiedad):?>
                        <div class="col-sm-6 mt-3">
                            <label for="<?=$propiedad->numero?>" class="form-label">
                                <input type="checkbox" name="propiedad[]" id="<?=$propiedad->numero?>" value="<?=$propiedad->numero?>" checked>
                                <?=' '.$propiedad->numero.' - '.$propiedad->nombre_inquilino?>
                            </label>
                        </div>
                        <?php endforeach;?>
                    </div>
                    
                    
                    <div>
                        <button type="submit" class="btn btn-primary mt-3">Alta Cuotas</button>
                    </div>
                </form>
            </div>
        </section>
        
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
    </body>
</html>