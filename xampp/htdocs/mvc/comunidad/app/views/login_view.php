<!DOCTYPE HTML>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Formulario de Acceso</title>
        <link rel="stylesheet" href="<?= URLROOT . '/public/css/foundation-icons.css' ?>" />
        <style>
            * {box-sizing: border-box;}
            html, body {margin: 0; padding: 0;}
            body {font-family: sans-serif, Arial, Helvetica;}
            
            .container img { position: relative; top: 13px;}

            h1 { text-align: center;}

            .info {
                background-color: coral;
                color: white;
                padding: 10px;
                text-align: center;
            }

            input[type=text], input[type=password] {
                width: 90%;
                padding: 12px 20px;
                margin: 15px 0;
                display: inline-block;
                background: lavender;
                border: none;
                border-bottom: 1px solid #ccc;
            }

            input[type=text]:focus-visible, input[type=password]:focus-visible {
                border:none!important;
            }
            
            input[type=submit] {
                background-color: #04AA6D;
                color: white;
                padding: 14px 20px;
                margin: 25px 0;
                border: none;
                cursor: pointer;
                width: 100%;
            }

            input[type=submit]:hover {
                opacity: 0.9;
            }

            #container {
                width: 100%;
                margin: 15px auto;
                padding: 2%;
                background-color: lavender;
                border-radius: 7px;
                -moz-border-radius: 7px;
                -webkit-border-radius: 7px;
            }

            .img_container img{
                display: block;
                margin: 0 auto;
            }

            @media screen and (min-width: 600px) {
                #container {
                    width: 70%;
                }
            }

            @media screen and (min-width: 1024px) {
                #container {
                    width: 500px;
                }
            }
        </style>        
    </head>
    <body>
        <div id="container">
            <form action="<?= URLROOT . '/login' ?>" method="post">
                <div class="img_container">
                    <img src="<?= URLROOT . '/public/img/avatar.png' ?>" alt="imagen Usuario" height="100" width="100" class="usuario">
                </div>

                <h1>Acceso</h1>
                <hr>
                <div class="container">
                    <img src="<?= URLROOT . '/public/img/person.svg' ?>" width="32" height="32" alt="User"/>
                    <input type="text" placeholder="Usuario" name="usuario" id="usuario" required>        
                    <img src="<?= URLROOT . '/public/img/file-lock.svg' ?>" width="32" height="32" alt="lock"/>
                    <input type="password" placeholder="Contraseña" name="password" id="password" required>

                    <input type="submit" value="Login">

                    <?php if (!empty($info)): ?>
                        <div class="info">
                            <?= $info ?>
                        </div>
                    <?php endif ?>
                </div>
            </form>            
        </div>

    </body>
</html>

