<!DOCTYPE html>
<html>
<head>
    <!-- Título de la página -->
    <title>Visitas del Paciente</title>
    <!-- Se vincula la hoja de estilos para definir el aspecto de la página -->
    <link rel="stylesheet" href="/DocControl/assets/css/estilos.css">
</head>
<body>
    <!-- Contenedor para los botones de visitas -->
    <div class="button-container">
        <?php
        // Establecer los parámetros para la conexión a la base de datos
        $servername = "localhost";
        $username   = "root";
        $password   = "";
        $dbname     = "clinica";

        // Conectar a la base de datos usando mysqli_connect
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Verificar si la conexión fue exitosa, en caso contrario, detener la ejecución y mostrar el error
        if (!$conn) {
            die("Conexión fallida: " . mysqli_connect_error());
        }

        // Iniciar la sesión para acceder a las variables de sesión
        session_start();

        // Obtener el valor de la CURP almacenado en la sesión, si no existe se asigna una cadena vacía
        $curp = isset($_SESSION['curp']) ? $_SESSION['curp'] : '';

        // Si la CURP no está vacía, se procede a consultar las fechas de visita del paciente
        if (!empty($curp)) {
            // Consulta SQL para obtener las fechas de visita únicas (DISTINCT) de la tabla FichaClinica
            // que correspondan al paciente identificado por su CURP, ordenándolas en orden descendente
            $sql = "SELECT DISTINCT fecha FROM FichaClinica WHERE paciente_curp = '$curp' ORDER BY fecha DESC";
            $result = mysqli_query($conn, $sql);

            // Si la consulta es exitosa y se encontraron registros...
            if ($result && mysqli_num_rows($result) > 0) {
                // Se recorren los resultados obtenidos
                while ($row = mysqli_fetch_assoc($result)) {
                    $fechaVisita = $row['fecha'];
                    // Se genera un enlace (botón) para cada fecha de visita que redirige a "Visitas.php"
                    // pasando la fecha por medio del parámetro GET
                    echo "<a class='button' href='Visitas.php?fecha=$fechaVisita'>$fechaVisita</a>";
                }
            } else {
                // Si no se encontraron visitas para el paciente, se muestra un mensaje informativo
                echo "No se encontraron visitas para este paciente.";
            }
        } else {
            // Si la CURP no se encuentra en la sesión, se muestra un mensaje de error
            echo "No se encontró el CURP en la sesión.";
        }

        // Cerrar la conexión a la base de datos para liberar recursos
        mysqli_close($conn);
        ?>

        <script>
            // Función JavaScript para redireccionar a la página "Visitas.php" pasando la fecha de visita
            function mostrarFormulario(fecha) {
                window.location.href = 'Visitas.php?fecha=' + fecha;
            }
        </script>
    </div>
</body>
</html>
