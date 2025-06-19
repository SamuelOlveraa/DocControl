<?php
// Definición de los parámetros para la conexión a la base de datos MySQL
$servername = "localhost";  // Dirección del servidor (en este caso, localhost)
$username = "root";         // Nombre de usuario de la base de datos
$password = "";             // Contraseña del usuario (vacía en este ejemplo)
$dbname = "clinica";        // Nombre de la base de datos a la que se desea acceder

// Se establece la conexión utilizando la función mysqli_connect
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Se verifica que la conexión se haya realizado correctamente
if (!$conn) {
    // Si la conexión falla, se detiene la ejecución del script y se muestra el error
    die("Conexión fallida: " . mysqli_connect_error());
}

// Recuperar los valores enviados por el formulario mediante el método POST
// Cada variable corresponde a un campo del formulario HTML
$curp = $_POST["Curp"];
$nombre = $_POST["Nombre"];
$apellidoPaterno = $_POST["ApellidoPaterno"];
$apellidoMaterno = $_POST["ApellidoMaterno"];
$edad = $_POST["Edad"];
$entidadNacimiento = $_POST["Entidad"];
$escolaridad = $_POST["Escolaridad"];
$derechoHabiencia = $_POST["Derechohabiente"];
$religion = $_POST["Religion"];
$estadoCivil = $_POST["EstadoCivil"];
$ocupacion = $_POST["Ocupacion"];
$fechaNacimiento = $_POST["FechaNacimiento"];
$genero = $_POST["Genero"];

// Se crea la consulta SQL para insertar un nuevo registro en la tabla "paciente"
// La consulta especifica los campos de la tabla y los valores correspondientes que se obtuvieron del formulario
$sql = "INSERT INTO paciente (curp, nombre, apellidoPaterno, apellidoMaterno, edad, entidadNacimiento, escolaridad, derechoHabiencia, religion, estadoCivil, ocupacion, fechaNacimiento, genero)
        VALUES ('$curp', '$nombre', '$apellidoPaterno', '$apellidoMaterno', '$edad', '$entidadNacimiento', '$escolaridad', '$derechoHabiencia', '$religion', '$estadoCivil', '$ocupacion', '$fechaNacimiento', '$genero')";

// Se ejecuta la consulta SQL utilizando la función mysqli_query
if (mysqli_query($conn, $sql)) {
    // Si la inserción se realiza correctamente, se almacena la CURP del paciente registrado
    $paciente_curp = $curp;
    // Se redirige al usuario a la página "Formularios.html" ubicada en el servidor local
    header("Location:/DocControl/views/Formularios.html");
} else {
    // Si ocurre algún error durante la ejecución de la consulta, se muestra un mensaje de error
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Se cierra la conexión a la base de datos para liberar los recursos utilizados
mysqli_close($conn);
?>
