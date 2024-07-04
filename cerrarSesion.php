<?php 
    // Verificamos si existe la variable sesión(que esté activa la sesión)
    if (session_status() == PHP_SESSION_NONE) {
        // La inicializo si no lo está
        session_start();
    }
    // Destruyo las varibales se sesión
    session_destroy();
    // Redirigimos
    header("Location:login.html");
    exit();
?>