<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errores = array();

    // Verificamos si recibimos esos datos del login.html
    //  print_r($_POST);

    // Se procede a validar

    // Incluimos la conexión a la base de datos
    include("conexionBD.php");

    //  $email =(isset($_POST['email']))?htmlspecialchars($_POST['email']):null; puede ser así o...

    // Inicializa la variable $email con un valor por defecto
    $email = null;

    // Verifica si el campo 'email' ha sido enviado con el formulario
    if ($_POST['email']) {
        // Guarda el valor del campo 'email' en la variable $email, asegurándose de escapar caracteres especiales
        $email = htmlspecialchars($_POST['email']);
    }

    if (empty($email)) {
        $errores['email'] = "El email es obligatorio!";
        /* Se verifica si el correo es válido mediante el siguiente filtro, que  
        inspecciona si tiene @ o .com .org..... en su estructura.*/
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "Formato de email incorrecto!";
    }

    $password = null;

    if ($_POST['password']) {
        $password = $_POST['password'];
    }

    if (empty($password)) {
        $errores['password'] = "La contraseña no puede estar vacia!";
    }

    if (empty($errores)) {
        // Seguimos con la conexión a la base de datos

        try {
            // Validamos la conexión y nos conectamos
            $pdo = new PDO('mysql:host=' . $direccionservidor . ';dbname=' . $baseDatos, $usuarioBD, $claveBD);
            /* De esta manera el PDO nos podrá mostrar los errores estándo en modo muestra
            ,para poder observar lo que succede*/
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Preparamos la consulta intentando no dejar espacios para evitar errores

            // Lo unico que estamos verificando aqui es que el mail exista en la bd, es una sentencia de busqueda
            $sql = "SELECT * FROM usuarios WHERE email=:email";
            $sentencia = $pdo->prepare($sql);
            $sentencia->execute(['email' => $email]);

            /* Imprimimos el resultado, que busca el primer registro 
        $usuarios = $sentencia->fetch(PDO::FETCH_ASSOC); */
            // print_r($usuarios);

            // Indicando fetchAll nos muestra todos los registros identicos
            $usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            //print_r($usuarios);


            $login = false;
            // Recorremos usuarios y por cada user
            foreach ($usuarios as $user) {

                // Validamos el password obtenido el html con todos los password de todos los usuarios,mediante cada user

                // Obtenemos el input del password y lo encriptamos para comprobarlo con la de la base de datos, previamente encriptado en registro.php
                if (password_verify($password, $user["password"])) {
                    // Si es que se encuentra, se inserta en un Vector ese user
                    $_SESSION['usuario_id'] = $user['id'];
                    $_SESSION['usuario_nombre'] = $user['nombres'] . " " . $user['apellidos'];
                    $login = true;
                    //  break; // Salir del bucle una vez que se ha encontrado un usuario válido
                }
            }
            /* Pruebas
                echo $password;
                echo $user["password"];
                */
            /* De esta manera se revisa el password sin encriptación directamente
                if ($password == $user["password"]) {
                    $login=true;  
                }*/


            if ($login) {
                echo "Existe en la BD!";
                // Redirigimos al index después de verificar el usuario
                header("Location:index.php");
            } else {
                /*
                 header("Location:login.html");
                 */


                foreach ($errores as $error) {
                    echo "</br> $error </br>";
                }
                echo "No existe el usuario,verifique el usuario o registrese!";

                echo "</br> <a href='login.html'>Regresar al login</a>";
            }
        } catch (PDOException $e) {
        }
    } /*else {
        
        foreach ($errores as $error) {
            echo "</br> $error </br>";
        }

        echo "</br> <a href='login.php'>Regresar al login</a>";
        
    }*/
}
