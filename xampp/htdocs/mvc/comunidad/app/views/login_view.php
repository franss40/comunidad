<!DOCTYPE HTML>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Formulario de Login</title>
        <style>
            * {box-sizing: border-box}
            body {font-family:  Helvetica, sans-serif, Arial;}

            input[type=text], input[type=password] {
                width: 100%;
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
            
            h1 { text-align: center;}
            .info {
                background-color: thistle;
                padding: 10px;
                text-align: center;
            }
            
            #container {
                width: 500px;
                margin: 30px auto;
                padding: 2% 2%;
                background-color: lavender;
            }
            
            .img_container img{
                display: block;
                margin: 0 auto;
            }
            
            @media screen and (max-width: 600px) {
                #container {
                    width: 100%;
                    margin: 50px auto;
                    padding: 5%;
                    background-color: lavender;
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
                
                <h1>Log In</h1>
                <hr>
                <div class="container">
                    <input type="text" placeholder="Usuario" name="usuario" id="usuario" required>        
                    <input type="password" placeholder="Contraseña" name="password" id="password" required>

                    <input type="submit" value="Login">
                    
                    <div class="info">
                        <?= $nombre ?>
                    </div>
                </div>
            </form>            
        </div>



        
    </body>
</html>

