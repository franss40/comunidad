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
                    <a href="<?= URLROOT . '/usuarios' ?>" class="pe-2">
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
                        <strong>Editar Comunidad</strong>
                    </li>
                </ol>
            </nav>
        </div>
        
        
        <section class="mt-4" role="main">            
            <div class="container bg-light p-3">
            <form action="" method="POST">
                <input type="hidden" name="token" class="form-control" value="<?=$token ?>">
                <div class="row mb-3">
                    <div class="col-sm-7">
                        <label for="cod" class="form-label">Código Comunidad</label>
                        <input type="text" name="cod" class="form-control" id="cod" value="" disabled>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-7">
                        <label for="nombre" class="form-label">Nombre Comunidad</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" class="form-control" id="direccion" required>
                    </div>
                    <div class="col">
                        <label for="codigo" class="form-label">Código Postal</label>
                        <input type="text" name="codigo" class="form-control" id="codigo" required>
                    </div>
                    <div class="col">
                        <label for="poblacion" class="form-label">Población</label>
                        <input type="text" name="poblacion" class="form-control" id="poblacion" required>
                    </div>
                </div>   
                
                <div class="row mb-4">
                    <div class="col">
                        <label for="cuota" class="form-label">Tipo de Cuota</label>
                        <select class="form-select" aria-label="Tipo de Cuota" id="cuota" name="cuota">
                            <option selected value="FIJA">FIJA</option>
                            <option value="VARIABLE">VARIABLE</option>
                        </select>
                    </div>                    
                </div>
                
                <div>
                    <button type="submit" class="btn btn-primary">Editar Comunidad</button>
                </div>
            </form>
            </div>
        </section>
        
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
    </body>
</html>
