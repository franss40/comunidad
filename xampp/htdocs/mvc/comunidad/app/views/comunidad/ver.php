<!DOCTYPE HTML>
<html lang="es">
    <head>    
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">        
        <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.6/build/grids-responsive-min.css" />
        <title>Comunidad</title>
    </head>
    
    <style type="text/css">
        
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        
        .sideNav{background-color: black; color: white; padding: 0;}
        a {
            text-decoration: none;
            color: rgb(61, 146, 201);
        }
        a:hover,
        a:focus {
            text-decoration: underline;
        }
        .main{
            padding: 2em 1em 0;
        }
        
        @media (min-width: 48em) {
            .sideNav{ position: fixed; top: 0; left: 0; height: 100%;}
            .main {
                margin-left: 25%;
                padding: 2em 3em 0;
            }
        }
    </style>
        
    <body>        
        <div class="pure-g">
            <div class="sideNav pure-u-1 pure-u-md-1-5">
                <p>Lateral</p>
            </div>
            
            <div class="main pure-u-1 pure-u-md-4-5">
                <h1>Comunidades</h1>
                <table class="pure-table">
                    <thead>
                        <tr>
                            <th>COD</th>
                            <th>NOMBRE</th>
                            <th>CALLE</th>
                        </tr>
                    <thead>
                    <tbody>
                        <?php foreach ($comunidad as $comunidad):?>
                            <tr>
                                <td><?= $comunidad->cod?></td>
                                <td><?= $comunidad->nombre?></td>
                                <td><?= $comunidad->calle?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        
        
        
        
    </body>
</html>