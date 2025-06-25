<?php
session_start();

// Verificar que la sesión contenga la CURP del paciente
if (!isset($_SESSION['paciente_curp'])) {
    header("Location: index.html");
    exit();
}

$paciente_curp = $_SESSION['paciente_curp'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Obtener y limpiar los valores del formulario
    $NombreMedicamento = trim($_POST["NombreMedicamento"]);
    $NombreActivo      = trim($_POST["NombreActivo"]);
    $Presentacion      = trim($_POST["Presentacion"]);
    $Dosis             = (int) trim($_POST["Dosis"]);
    $Via               = trim($_POST["Via"]);
    $FechaUlAdmin      = trim($_POST["FechaUlAdmin"]);
    $HoraUlAdmin       = isset($_POST["hora"]) ? trim($_POST["hora"]) : '';

    // Depuración: imprimir el contenido de $_POST
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    // Verifica que se esté recibiendo un valor en 'hora'
    // echo "Hora recibida: '" . $HoraUlAdmin . "'";

    // Validar que los campos obligatorios no estén vacíos
    if (empty($NombreMedicamento) || empty($NombreActivo) || empty($Presentacion) ||
        empty($Via) || empty($FechaUlAdmin) || empty($HoraUlAdmin)) {
        die("Por favor, complete todos los campos obligatorios.");
    }

    // Conexión a la base de datos
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $dbname     = "clinica";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Preparar la consulta usando sentencias preparadas
    $stmt = $conn->prepare("INSERT INTO Medicamentos (paciente_curp, NombreMedicamento, NombreActivo, Presentacion, Dosis, Via, FechaUlAdmin, HoraUlAdmin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Vincular los parámetros (s = string, i = integer)
    $stmt->bind_param("ssssiiss", $paciente_curp, $NombreMedicamento, $NombreActivo, $Presentacion, $Dosis, $Via, $FechaUlAdmin, $HoraUlAdmin);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        header("Location: /DocControl/views/MedicamentosUsReg.html");
        exit();
    } else {
        echo "Error al registrar el medicamento: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "No se ha enviado el formulario.";
    exit();
}
?>
