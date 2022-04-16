<!DOCTYPE HTML>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Formulario de Acceso</title>
        <link rel="stylesheet" href="<?= URLROOT . '/public/css/loginCss.css' ?>" />       
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Redressed&family=Staatliches&display=swap');
        </style>
    </head>
    <body>
        <div id="container">

            <form action="<?= URLROOT . '/login' ?>" method="post">
                <div class="img_container">
                    <img src="<?= URLROOT . '/public/img/avatar2.png' ?>" alt="imagen Usuario" height="100" width="100" class="usuario">
                </div>

                <h1>COMUNI</h1>
                <hr>
                <div class="container">
                    <input type="hidden" name="token" value="<?=$token ?>">
                    <img src="<?= URLROOT . '/public/img/person.svg' ?>" width="36" height="36" alt="User"/>
                    <input type="text" placeholder="apellido" name="apellido" id="apellido" value="" style="display:none;">
                    <input type="text" placeholder="Usuario" name="usuario" id="usuario" required>        
                    <img src="<?= URLROOT . '/public/img/unlock.svg' ?>" width="36" height="36" alt="lock"/>
                    <input type="password" placeholder="Contraseña" name="password" id="password" required>

                    <input type="submit" value="Acceso">


                    <div class="info">
                        <?= $info ?>
                    </div>
                </div>
            </form> 
        </div>

    </body>
</html>

