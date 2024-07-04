<!--
Se puede acceder sin estar logeados al index.php y para ello tendremos que emplear
las variables de sesión y bloquear la ruta.
Hay que validar que el usuario ha iniciado sesión 

https://www.youtube.com/watch?v=PwCOJnnCS5s
 -->


<?php
session_start();

// Si no existe la variable inicio de sesión
if (!$_SESSION['usuario_id']) {
    // Redirigimos
    header("Location:login.html");
    exit();
}

// print_r($_SESSION);
?>


<!doctype html>
<html lang="en">

<head>
    <title>Panel de bienvenida</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Panel administrador</a>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">

                        <li class="nav-item">
                            <a class="nav-link" href="https://chatgpt.com">ChatGPT</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="https://github.com/Lernik1998">GitHub del autor</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="cerrarSesion.php">Cerrar</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>


        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col">

                    <h2>Inicio de la aplicación</h2>

                    <h3>Bienvenid@ <?php echo $_SESSION['usuario_nombre']; ?></h3>

                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">

                    <div class="card">
                        <div class="card-header">Información</div>
                        <div class="card-body">
                            <h4 class="card-title">Detalles</h4>
                            <img src="php.png" alt="foto" class="card-img-top mx-auto d-block">
                        </div>
                        <div class="card-footer text-muted">PHP,JavaScript,BootStrap 5</div>
                    </div>

                </div>
            </div>


        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>