<html>
    <head>
        <title>Formulario de Login</title>
    </head>
    <body>
        <h1>Formulario de Login</h1>
        <form action="<?= URLROOT . '/login' ?>" method="post">
            nombre
            <input type="text" name="nombre">
            <input type="submit">
        </form>
        <?=$nombre ?>
    </body>
</html>

