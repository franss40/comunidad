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
        
        <section class="container-fluid mt-2" role="info">
            <div class="row">
                <div class="col-md-6 bg-info text-black text-center p-2"><?=$info?></div>
                <div class="col-md-6 bg-success text-white text-center p-2"><?= $nombreComunidad ?></div>
            </div>
        </section>
        
        <br>
        <div class="container">
            <nav aria-label="breadcrumb" class="mt-2 ps-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        Usted está en: <strong><a href="<?= URLROOT . '/comunidad' ?>">Origen</a></strong>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <strong><a href="<?= URLROOT . '/propiedad/comunidad/'. $codComunidad ?>">Propiedad</a></strong>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <strong>Alta Propiedad</strong>
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
                        <div class="col-md-4">
                            <label for="cod" class="form-label">Código Comunidad</label>
                            <input type="number" name="cod" class="form-control text-end" id="cod" value="<?=$codComunidad ?>" readonly>
                        </div>
                        <div class="col">
                            <label for="numero" class="form-label">Vivienda</label>
                            <input type="text" name="numero" class="form-control" id="numero" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nombre" class="form-label">Nombre Propietario</label>
                            <input type="text" name="nombre" class="form-control" id="nombre" required>
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email Propietario</label>
                            <input type="email" name="email" class="form-control" id="email">
                        </div>
                        <div class="col-md-4">
                            <label for="tf" class="form-label">Teléfono Propietario</label>
                            <input type="text" name="tf" class="form-control" id="tf">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombreInquilino" class="form-label">Nombre Inquilino</label>
                            <input type="text" name="nombreInquilino" class="form-control" id="nombreInquilino">
                        </div>
                        <div class="col-md-6">
                            <label for="tfInquilino" class="form-label">Teléfono Inquilino</label>
                            <input type="text" name="tfInquilino" class="form-control" id="tfInquilino">
                        </div>  
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="superficie" class="form-label">Superficie</label>
                            <input type="text" name="superficie" class="form-control" id="superficie">
                        </div>
                        <div class="col">
                            <label for="participacion" class="form-label">Participación</label>
                            <input type="text" name="participacion" class="form-control" id="participacion" required>
                        </div>
                        <div class="col">
                            <label for="cuota" class="form-label">Cuota</label>
                            <input type="text" name="cuota" class="form-control" id="cuota" required>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col">
                            <label for="cuenta" class="form-label">Cuenta Bancaria</label>
                            <input type="text" name="cuenta" class="form-control" id="cuenta">
                        </div>                        
                        <div class="col">
                            <label for="tipo" class="form-label">Tipo Propiedad</label>
                            <select class="form-select" aria-label="tipo" id="tipo" name="tipo">
                                <option value="VIVIENDA" selected>VIVIENDA</option>
                                <option value="OFICINA">OFICINA</option>
                                <option value="GARAJE">GARAJE</option>
                                <option value="LOCAL">LOCAL</option>
                            </select>
                        </div>                    
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Alta Propiedad</button>
                </form>
            </div>
        </section>
        
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
    </body>
</html>