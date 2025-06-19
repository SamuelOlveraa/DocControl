<?php
// Establecer la conexión con la base de datos
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "clinica";

// Se utiliza mysqli_connect para establecer la conexión a la base de datos.
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Iniciar la sesión para poder almacenar y usar variables de sesión.
session_start();

// Se obtiene la CURP desde el parámetro GET de la URL; si no se proporciona, se asigna una cadena vacía.
$curp = isset($_GET['curp']) ? $_GET['curp'] : '';

// Se almacenan la CURP en variables de sesión para su uso posterior.
$_SESSION['curp'] = $curp;
$_SESSION['paciente_curp'] = $curp;

// Se verifica que se haya proporcionado la CURP en la URL.
if (isset($_GET['curp'])) {

    // Si se ha enviado el formulario, se revisa el valor del campo "action" para determinar qué acción realizar.
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'actualizar') {
            // Capturar los valores modificados del formulario.
            $nombre             = $_POST['Nombre'];
            $apellidoPaterno    = $_POST['ApellidoPaterno'];
            $apellidoMaterno    = $_POST['ApellidoMaterno'];
            $edad               = $_POST['Edad'];
            $entidadNacimiento  = $_POST['Entidad'];
            $escolaridad        = $_POST['Escolaridad'];
            $derechoHabiencia   = $_POST['Derechohabiente'];
            $religion           = $_POST['Religion'];
            $estadoCivil        = $_POST['EstadoCivil'];
            $ocupacion          = $_POST['Ocupacion'];
            $fechaNacimiento    = $_POST['FechaNacimiento'];
            $genero             = $_POST['Genero'];

            // Se crea la consulta SQL para actualizar los datos del paciente en la tabla "paciente"
            $sql = "UPDATE paciente SET 
                        nombre='$nombre', 
                        apellidoPaterno='$apellidoPaterno', 
                        apellidoMaterno='$apellidoMaterno', 
                        edad='$edad', 
                        entidadNacimiento='$entidadNacimiento', 
                        escolaridad='$escolaridad', 
                        derechoHabiencia='$derechoHabiencia', 
                        religion='$religion', 
                        estadoCivil='$estadoCivil', 
                        ocupacion='$ocupacion', 
                        fechaNacimiento='$fechaNacimiento', 
                        genero='$genero' 
                    WHERE curp='$curp'";

            if (mysqli_query($conn, $sql)) {
                // Los datos se actualizaron correctamente.
                // Aquí se podrían realizar acciones adicionales (mostrar un mensaje, registrar en log, etc.).
            } else {
                echo "Error al actualizar los datos del paciente: " . mysqli_error($conn);
            }
        } elseif ($_POST['action'] === 'ver_consultas') {
            // Redirigir a la página de consultas.
            header("Location: Consultas.php");
            exit;
        } elseif ($_POST['action'] === 'ver_Informacion') {
            // Redirigir a la página con la información editable.
            header("Location: FormulariosEditables.html");
            exit;
        } elseif ($_POST['action'] === 'crear_consulta') {
            // Redirigir a la página para crear una nueva consulta.
            header("Location: FichaClinica.html");
            exit;
        }
    }

    // Se consulta la base de datos para recuperar la información del paciente con la CURP proporcionada.
    $sql = "SELECT * FROM paciente WHERE curp = '$curp'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Si la consulta es exitosa, se extraen los datos en un arreglo asociativo.
        $row = mysqli_fetch_assoc($result);
        $nombre             = $row["nombre"];
        $apellidoPaterno    = $row["apellidoPaterno"];
        $apellidoMaterno    = $row["apellidoMaterno"];
        $edad               = $row["edad"];
        $entidadNacimiento  = $row["entidadNacimiento"];
        $escolaridad        = $row["escolaridad"];
        $derechoHabiencia   = $row["derechoHabiencia"];
        $religion           = $row["religion"];
        $estadoCivil        = $row["estadoCivil"];
        $ocupacion          = $row["ocupacion"];
        $fechaNacimiento    = $row["fechaNacimiento"];
        $genero             = $row["genero"];
    } else {
        // Si no se encontró ningún paciente con la CURP proporcionada, redirige a la página de error.
        header("Location: error.php");
        exit();
    }
} else {
    // Si no se proporcionó la CURP en la URL, redirige a la página de error.
    header("Location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Metadatos básicos -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!-- Se vincula la hoja de estilos -->
    <link rel="stylesheet" href="/DocControl/assets/css/estilos.css" />
</head>
<body>
    <!-- Contenedor principal -->
    <section class="container">
        <h1 style="text-align: center;">Paciente encontrado</h1>
        <!-- Formulario para mostrar y actualizar la información del paciente -->
        <form method="POST" class="form" id="formulario">
            <!-- Primera columna: Nombre y Apellidos -->
            <div class="column">
                <div class="input-box">
                    <label>Nombre(s)</label>
                    <input type="text" id="nombre" name="Nombre" value="<?php echo $nombre; ?>" />
                </div>
                <div class="input-box">
                    <label>Apellido Paterno</label>
                    <input type="text" id="apellidoPaterno" name="ApellidoPaterno" value="<?php echo $apellidoPaterno; ?>" />
                </div>
                <div class="input-box">
                    <label>Apellido Materno</label>
                    <input type="text" id="apellidoMaterno" name="ApellidoMaterno" value="<?php echo $apellidoMaterno; ?>" />
                </div>
            </div>
            <!-- Segunda columna: Edad, Derechohabiente y Fecha de Nacimiento -->
            <div class="column">
                <div class="input-box">
                    <label>Edad</label>
                    <input type="number" id="edad" name="Edad" value="<?php echo $edad; ?>" />
                </div>
                <div class="input-box">
                    <label>Derechohabiente</label>
                    <input type="text" name="Derechohabiente" value="<?php echo $derechoHabiencia; ?>" />
                </div>
                <div class="input-box">
                    <label>Fecha de Nacimiento</label>
                    <input type="date" name="FechaNacimiento" id="fechaNacimiento" value="<?php echo $fechaNacimiento; ?>" />
                </div>
            </div>
            <!-- Tercera columna: Entidad, Género y Escolaridad -->
            <div class="column">
                <div class="input-box">
                    <label>Entidad de Nacimiento</label>
                    <input type="text" name="Entidad" value="<?php echo $entidadNacimiento; ?>" />
                </div>
                <div class="input-box">
                    <label>Genero</label>
                    <input type="text" name="Genero" value="<?php echo $genero; ?>" />
                </div>
                <div class="input-box">
                    <label>Escolaridad</label>
                    <input type="text" name="Escolaridad" value="<?php echo $escolaridad; ?>" />
                </div>
            </div>
            <!-- Campo adicional para mostrar la CURP (lectura solamente) -->
            <div class="input-box">
                <label>CURP</label>
                <input type="text" id="curp" name="Curp" value="<?php echo $curp; ?>" readonly />
            </div>
            <!-- Botones para ejecutar diferentes acciones -->
            <div class="column">
                <button type="submit" name="action" value="ver_Informacion">Ver Información</button>
                <button type="submit" name="action" value="actualizar">Actualizar</button>
                <button type="submit" name="action" value="ver_consultas">Ver Consultas</button>
                <button type="submit" name="action" value="crear_consulta">Crear consulta</button>
            </div>
            <!-- Botón para regresar al menú principal (redirección mediante JavaScript) -->
            <button type="button" onclick="window.location.href = '/DocControl/public/index.html'">Menu Principal</button>
        </form>
    </section>
</body>
</html>
