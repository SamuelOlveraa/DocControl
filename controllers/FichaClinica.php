<?php
// Activar errores (útil durante desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificar método POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validar existencia de la CURP en la sesión
    if (!isset($_SESSION["paciente_curp"])) {
        die("Error: CURP del paciente no encontrada en la sesión.");
    }
    $paciente_curp = $_SESSION["paciente_curp"];

    // Función para sanitizar texto
    function limpiar($dato) {
        return htmlspecialchars(trim($dato));
    }

    // Sanitización y extracción
    $fecha                    = limpiar($_POST["Fecha"] ?? '');
    $MoIngreso                = limpiar($_POST["MoIngreso"] ?? '');
    $PriEvo                   = limpiar($_POST["PriEvo"] ?? '');
    $ResCardio                = limpiar($_POST["ResCardio"] ?? '');
    $Digestivo                = limpiar($_POST["Digestivo"] ?? '');
    $Endocrino                = limpiar($_POST["Endocrino"] ?? '');
    $MusEsqueletico           = limpiar($_POST["MusEs"] ?? '');
    $GenitoUrinario           = limpiar($_POST["GenUr"] ?? '');
    $PielAnexos               = limpiar($_POST["PielAnex"] ?? '');
    $Neuropsiquiatrico        = limpiar($_POST["NeuPsi"] ?? '');
    $TA                       = limpiar($_POST["ta"] ?? '');
    $Pulso                    = intval($_POST["pulso"] ?? 0);
    $Temperatura              = floatval($_POST["Temp"] ?? 0);
    $Peso                     = limpiar($_POST["Peso"] ?? '');
    $Talla                    = limpiar($_POST["Talla"] ?? '');
    $HabitusExterior          = limpiar($_POST["Habitus"] ?? '');
    $CabezaCuello             = limpiar($_POST["CabCue"] ?? '');
    $Torax                    = limpiar($_POST["Torax"] ?? '');
    $Abdomen                  = limpiar($_POST["Abdomen"] ?? '');
    $Genitales                = limpiar($_POST["Genitales"] ?? '');
    $Extremidades             = limpiar($_POST["Extremidades"] ?? '');
    $SistemaNervioso          = limpiar($_POST["SistemNerv"] ?? '');
    $ProbablesDiagnostico     = limpiar($_POST["ProDiagnostico"] ?? '');
    $PlanEstudio              = limpiar($_POST["PlanEstudio"] ?? '');
    $TerapeuticaInicial       = limpiar($_POST["TerapeuticaInicial"] ?? '');
    $ObservacionesComentarios = limpiar($_POST["Observaciones"] ?? '');
    $Condicion                = limpiar($_POST["Condicion"] ?? '');
    $Pronostico               = limpiar($_POST["Pronostico"] ?? '');

    // Conexión a base de datos
    $conn = new mysqli("localhost", "root", "", "clinica");
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // SQL con prepared statement
    $sql = "INSERT INTO FichaClinica (
                paciente_curp, fecha, MoIngreso, PriEvo, ResCardio, Digestivo, Endocrino, 
                MusEsqueletico, GenitoUrinario, PielAnexos, Neuropsiquiatrico, TA, Pulso, Temperatura, 
                Peso, Talla, HabitusExterior, CabezaCuello, Torax, Abdomen, Genitales, Extremidades, 
                SistemaNervioso, ProbablesDiagnostico, PlanEstudio, TerapeuticaInicial, 
                ObservacionesComentarios, Condicion, Pronostico
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Vincular parámetros
    $stmt->bind_param(
        "sssssssssssssdsssssssssssssss",
        $paciente_curp, $fecha, $MoIngreso, $PriEvo, $ResCardio, $Digestivo, $Endocrino,
        $MusEsqueletico, $GenitoUrinario, $PielAnexos, $Neuropsiquiatrico, $TA, $Pulso, $Temperatura,
        $Peso, $Talla, $HabitusExterior, $CabezaCuello, $Torax, $Abdomen, $Genitales, $Extremidades,
        $SistemaNervioso, $ProbablesDiagnostico, $PlanEstudio, $TerapeuticaInicial,
        $ObservacionesComentarios, $Condicion, $Pronostico
    );

    // Ejecutar inserción
    if ($stmt->execute()) {
        // Mensaje de éxito (puedes reemplazar por redirección si prefieres)
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Registro Exitoso</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f0f2f5;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                    margin: 0;
                }
                .container {
                    background: #fff;
                    padding: 30px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    text-align: center;
                    max-width: 400px;
                    width: 90%;
                }
                .btn {
                    background-color: #007BFF;
                    color: #fff;
                    padding: 10px 20px;
                    margin: 10px 5px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    font-size: 16px;
                }
                .btn:hover {
                    background-color: #0056b3;
                }
                .btn-secondary {
                    background-color: #6c757d;
                }
                .btn-secondary:hover {
                    background-color: #5a6268;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <p>Los datos se han registrado correctamente.</p>
                <p>¿Desea agregar medicamentos?</p>
                <form action='/DocControl/views/MedicamentosUsReg.html' method='GET'>
                    <input type='hidden' name='paciente_curp' value='$paciente_curp'>
                    <button type='submit' class='btn'>Agregar medicamentos</button>
                </form>
                <form action='/DocControl/controllers/Buscar.php' method='GET'>
                    <button type='submit' class='btn btn-secondary'>No agregar medicamentos</button>
                </form>
            </div>
        </body>
        </html>";
    } else {
        echo "Error al registrar ficha: " . $stmt->error;
    }

    // Cierre de recursos
    $stmt->close();
    $conn->close();
}
?>
