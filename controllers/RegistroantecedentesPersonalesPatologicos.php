<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- 1. Obtener los valores del formulario ---
    // Nota: Los nombres de los campos deben coincidir con los definidos en el formulario HTML.
    $enfermedades_infancia = $_POST["enfinfanciaOpc"];
    // Se omite el campo "cuales_infancia" ya que la tabla no lo tiene.
    $secuelas_infancia = $_POST["secuelaenf"];
    $hospitalizaciones_previas = $_POST["hospitalOpc"];
    $especificacion_hospitalizaciones = $_POST["hosespecifica"];
    $antecedentes_quirurgicos = $_POST["quirurgicosOpc"];
    $especificacion_quirurgicos = $_POST["quirurespecifica"];
    $transfusiones_previas = $_POST["trasfucionesOpc"];
    $especificacion_transfusiones = $_POST["trasfespecifica"];
    $fracturas = $_POST["fracturasOpc"];
    $especificacion_fracturas = $_POST["fracespecifica"];
    $traumatismos = $_POST["traumatismosOpc"];
    $especificacion_traumatismos = $_POST["trauespecifica"];
    $otra_enfermedad = $_POST["otraenfOpc"];
    $especificacion_otra_enfermedad = $_POST["otraenfespecifica"];
    
    // --- 2. Conectar con la base de datos ---
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "clinica";
    
    // Crear la conexión utilizando MySQLi orientado a objetos
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }
    
    // --- 3. Obtener la CURP del último paciente registrado ---
    // Se asume que en la tabla "paciente" existe un campo "curp"
    $sql = "SELECT curp FROM paciente ORDER BY curp DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $paciente_curp = $row["curp"];
    } else {
        echo "No se encontró ningún paciente registrado.";
        exit;
    }
    
    // --- 4. Crear la consulta SQL para insertar los antecedentes personales patológicos ---
    $sql = "INSERT INTO antecedentes_personales_patologicos (
                paciente_curp,
                enfermedades_infancia,
                secuelas_infancia,
                hospitalizaciones_previas,
                especificacion_hospitalizaciones,
                antecedentes_quirurgicos,
                especificacion_quirurgicos,
                transfusiones_previas,
                especificacion_transfusiones,
                fracturas,
                especificacion_fracturas,
                traumatismos,
                especificacion_traumatismos,
                otra_enfermedad,
                especificacion_otra_enfermedad
            ) VALUES (
                '$paciente_curp',
                '$enfermedades_infancia',
                '$secuelas_infancia',
                '$hospitalizaciones_previas',
                '$especificacion_hospitalizaciones',
                '$antecedentes_quirurgicos',
                '$especificacion_quirurgicos',
                '$transfusiones_previas',
                '$especificacion_transfusiones',
                '$fracturas',
                '$especificacion_fracturas',
                '$traumatismos',
                '$especificacion_traumatismos',
                '$otra_enfermedad',
                '$especificacion_otra_enfermedad'
            )";
    
    if ($conn->query($sql) === TRUE) {
        header("Location:/DocControl/views/Formularios.html");
        exit;
    } else {
        echo "Error al registrar los datos: " . $conn->error;
    }
    
    // --- 5. Cerrar la conexión ---
    $conn->close();
}
?>
