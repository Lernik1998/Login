

<?php
/* Visualizamos que toda la información está en un Vector para posteriormente 
introducirla en la tabla usuarios(Base de datos "loginBD")*/

// Si hay algún método que envia mediante POST, que se imprima esa información


if ($_SERVER["REQUEST_METHOD"] == "POST") {

/* Con esto incluimos la base de datos y accedemos a ella desde
el archivo conexionBD.php,que los datos de la Base de Datos*/

include("conexionBD.php");
// Es como un extends en Java creo.....nos permite acceder a el
    $success =false;

    // Vector de errores

    $errores = array();

    /* Para verificar que la información ya ha llegado, con print_r visualizamos
        que tipos de datos y que información está llegando!,porque si no apareceria array(),
        totalmente vacio. 

    print_r($_POST);
    */

    /* 
        Validamos datos para poder insertarlo en el registro 
        Si hay un dato llamado nombres lo asignaremos,si no lo dejamos null
        Obtenemos los datos indicando el name que aparece en el HTML
        */

    $nombres = (isset($_POST['nombres'])) ? $_POST['nombres'] : null;

    $apellidos = (isset($_POST['apellidos'])) ? $_POST['apellidos'] : null;

    $email = (isset($_POST['email'])) ? $_POST['email'] : null;

    $password = (isset($_POST['password'])) ? $_POST['password'] : null;

    $genero = (isset($_POST['genero'])) ? $_POST['genero'] : null;

    $confirmarPassword = (isset($_POST['confirmarPassword'])) ? $_POST['confirmarPassword'] : null;

    /* Pruebas para verificar que se está obteniendo 
        lo esperado.

        echo "el mail: ";
        echo $email;
        echo "apellido: ";
        echo $apellidos;
        echo "pass: ";
        echo $password;
        echo "genero: ";
        echo $genero;
        */

    /* Esta variable está dentro de include("conexionBD.php");
        y nos sirve para ver si está disponible, pero por el momento
        no nos hemos conectado.

         echo $baseDatos;
        */


    if (empty($nombres)) {
        $errores['nombres'] = "Debe de introducir un nombre!";
    }

    if (empty($apellidos)) {
        $errores['apellidos'] = "Debe de introducir un apellido!";
    }

    if (empty($genero)) {
        $errores['genero'] = "Debe de seleccionar un genero!";
    }

    if (empty($email)) {
        $errores['email'] = "El email es obligatorio!";

        /* Se verifica si el correo es válido mediante el siguiente filtro, que  
        inspecciona si tiene @ o .com .org..... en su estructura.*/
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "Formato de email incorrecto!";
    }

    // Validación del password
    /*
    Por el momento no se usa, pero es conveniente para mayor seguridad.

    if (strlen($password) < 6) {
        $errores['password'] = "La contraseña debe de tener más de 5 caracetes!";
    }*/

    if (empty($password)) {
        $errores['password'] = "La contraseña no puede estar vacia!";
    }

    if (empty($confirmarPassword)) {
        $errores['confirmarPassword'] = "Confirma la contraseña!";
    } elseif ($password != $confirmarPassword) {
        $errores['confirmarPassword'] = "Las contraseñas no coinciden!";
    }

    // Control de errores 

    foreach ($errores as $error) {
        echo "</br> $error </br>";
    }

    // print_r($errores);
    // Verificamos que no haya nada en el vector errores, es decir, que no hayan errores, si es true

    if (empty($errores)) {
        // Realizando conexión a la Base de datos

        try {
            // pdo es un objeto que se comunica con el servidor 
            $pdo = new PDO('mysql:host=' . $direccionservidor . ';dbname=' . $baseDatos, $usuarioBD, $claveBD);
            /* De esta manera el PDO nos podrá mostrar los errores estándo en modo muestra
            ,para poder observar lo que succede*/
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            // Se realiza la ENCRIPTACIÓN DE LA CONTRASEÑA

            $nuevoPassword = password_hash($password,PASSWORD_DEFAULT);


            /* Ahora empezaré a insertar en la Base de datos, es muy parecido a JAVA,
            cuando haciamos las conexiones a la BD */


            // Primero preparamos la consulta
            $sql = "INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `email`, `password`, `genero`)
             VALUES (NULL, :nombres, :apellidos, :email,:password,:genero);";

            //Instrucción de inserción
            $resultado = $pdo->prepare($sql);

            // Ejecuto la instrucción y envio la información mediante un Vector
            $resultado->execute(array(
                ':nombres' => $nombres,
                ':apellidos' => $apellidos,
                ':email' => $email,
                ':password' => $nuevoPassword,
                ':genero' => $genero
            ));

            /* 
            Redireccionamos también si todo a ido bien.
            Después de registrarse que pueda logearse 
            */

           //  header("Location:login.html");
           $success =true;

            // Para ver si hubo algún error en la conexión
        } catch (PDOException $e) {
            echo "Error detectado en la conexión!" . $e->getMessage();
        }
    } else {
        // Al haber errores redirecionamos 
       
        echo "No se han registrado los datos!";
    }
}


?>
<!doctype html>
<html lang="en">

<head>
    <title>Registro</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8">


                <?php
                if (isset($success)) { ?>
                 
                    <!--Mensaje para informar que se ha registrado exitosamente!-->
                   
                    <div
                        class="alert alert-success alert-dismissible fade show"
                        role="alert"
                    >
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"
                        ></button>
                    
                        <strong>!Registro exitoso ¡</strong> Puede proceder a realizar el login.
                        <a href="login.html" class="btn btn-success">Login</a>
                    </div>
                    
                <?php } ?>
                   
                   
                    <div class="card">
                        <div class="card-header">Formulario de registro</div>
                        <div class="card-body">
                            <!--Lo obtenido del formulario se envia a registro.php-->

                            <form action="registro.php" id="formularioDeRegistro" method="post">

                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" name="nombres" id="nombres"
                                                aria-describedby="helpId" placeholder="" required />
                                        </div>

                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Apellidos</label>
                                            <input type="text" class="form-control" name="apellidos" id="apellidos"
                                                aria-describedby="helpId" placeholder="" required />
                                        </div>
                                    </div>

                                </div>


                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        aria-describedby="emailHelpId" placeholder="abc@mail.com" required />
                                </div>


                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Contreseña</label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="" required />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Repetir contraseña</label>
                                            <input type="password" 
                                            class="form-control" 
                                            name="confirmarPassword"
                                            id="confirmarPassword" 
                                            placeholder="" 
                                            required />
                                            <div class="invalid-feedback">Las contraseñas no coinciden</div>
                                        </div>
                                    </div>
                                </div>


                                <label for="genero" class="form-label">Género</label>
                                <select class="form-select" name="genero" id="genero" required>
                                    <option value="">Selecione su género:</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select><br>


                                <button type="submit" class="btn btn-success">Registrarme</button>
                                <a href="login.html" class="btn btn-secondary">Login</a>

                        </div>
                        <div class="card-footer text-muted"></div>
                    </div>

                    </form>
                </div>
            </div>

        </div>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <!--Vamos a verificar que ambas contraseñas coincidan a través de JavaScript-->
    <script>

        // Cuando se vaya a enviar el formulario, se realizará una serie de eventos

        document.addEventListener('DOMContentLoaded', function(){

            document.getElementById("formularioDeRegistro").addEventListener('submit', function(event){

                var contra = document.getElementById("password").value;
                var confiContra = document.getElementById("confirmarPassword").value;

                if (contra !== confiContra) {
                    // Añadimos una clase bootstrap
                    document.getElementById('confirmarPassword').classList.add('is-invalid');
                    // Prevenimos que se envie el formulario 
                    event.preventDefault();

                } else {
                    document.getElementById('confirmarPassword').classList.remove('is-invalid');

                }
            });
        });




    </script>
</body>

</html>

