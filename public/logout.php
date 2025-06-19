<?php
session_start(); // Iniciar sesión (asegúrate de incluir esto al principio de tu archivo PHP)

// Eliminar todas las variables de sesión
$_SESSION = array();


// Redirigir al usuario a la página de inicio de sesión o a otra página deseada
header("Location: http:/index.html");
exit();
?>
