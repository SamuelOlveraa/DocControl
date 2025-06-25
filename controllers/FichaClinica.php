<?php
// Iniciar la sesión para poder utilizar variables de sesión
session_start();

// Verificar que el formulario se haya enviado mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Extraer los valores enviados desde el formulario utilizando $_POST
    $fecha                    = $_POST["Fecha"];                     // Fecha de la visita
    $MoIngreso                = $_POST["MoIngreso"];                 // Motivo de ingreso
    $PriEvo                   = $_POST["PriEvo"];                    // Principio y evolución del padecimiento actual
    $ResCardio                = $_POST["ResCardio"];                 // Información del sistema respiratorio/cardiovascular
    $Digestivo                = $_POST["Digestivo"];                 // Información del sistema digestivo
    $Endocrino                = $_POST["Endocrino"];                 // Información del sistema endocrino
    $MusEsqueletico           = $_POST["MusEs"];                     // Información del sistema musculo-esquelético
    $GenitoUrinario           = $_POST["GenUr"];                     // Información del sistema genito-urinario
    $PielAnexos               = $_POST["PiAnex"];                    // Información del sistema piel y anexos
    $Neuropsiquiatrico        = $_POST["NeuPsi"];                    // Información del sistema neurológico y psiquiátrico
    $TA                       = $_POST["ta"];                        // Tensión arterial
    $Pulso                    = $_POST["pulso"];                     // Frecuencia cardíaca (pulso)
    $Temperatura              = $_POST["Temp"];                      // Temperatura corporal
    $Peso                     = $_POST["Peso"];                      // Peso del paciente
    $Talla                    = $_POST["Talla"];                     // Talla o estatura
    $HabitusExterior          = $_POST["Habitus"];                   // Descripción del habitus exterior
    $CabezaCuello             = $_POST["CabCue"];                    // Información de la cabeza y cuello
    $Torax                    = $_POST["Torax"];                     // Información del tórax
    $Abdomen                  = $_POST["Abdomen"];                   // Información del abdomen
    $Genitales                = $_POST["Genitales"];                 // Información de los genitales
    $Extremidades             = $_POST["Extremidades"];              // Información de las extremidades
    $SistemaNervioso          = $_POST["SistemNerv"];                // Información del sistema nervioso
    $ProbablesDiagnostico     = $_POST["ProDiagnostico"];            // Probable diagnóstico
    $PlanEstudio              = $_POST["PlanEstudio"];               // Plan de estudio
    $TerapeuticaInicial       = $_POST["TerapeuticaInicial"];        // Terapéutica inicial
    $ObservacionesComentarios = $_POST["Observaciones"];             // Observaciones y comentarios finales
    $Condicion                = $_POST["Condicion"];                 // Condición del paciente
    $Pronostico               = $_POST["Pronostico"];                // Pronóstico

    // Recuperar la CURP del paciente almacenada en la variable de sesión
    $paciente_curp = $_SESSION["paciente_curp"];

    // Parámetros para conectar a la base de datos
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $dbname     = "clinica";

    // Crear una nueva conexión a la base de datos usando mysqli
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Crear la consulta SQL para insertar los datos de la ficha clínica en la tabla FichaClinica
    $sql = "INSERT INTO FichaClinica (
                paciente_curp, fecha, MoIngreso, PriEvo, ResCardio, Digestivo, Endocrino, 
                MusEsqueletico, GenitoUrinario, PielAnexos, Neuropsiquiatrico, TA, Pulso, Temperatura, 
                Peso, Talla, HabitusExterior, CabezaCuello, Torax, Abdomen, Genitales, Extremidades, 
                SistemaNervioso, ProbablesDiagnostico, PlanEstudio, TerapeuticaInicial, 
                ObservacionesComentarios, Condicion, Pronostico
            ) VALUES (
                '$paciente_curp', '$fecha', '$MoIngreso', '$PriEvo', '$ResCardio', '$Digestivo', '$Endocrino', 
                '$MusEsqueletico', '$GenitoUrinario', '$PielAnexos', '$Neuropsiquiatrico', '$TA', '$Pulso', '$Temperatura', 
                '$Peso', '$Talla', '$HabitusExterior', '$CabezaCuello', '$Torax', '$Abdomen', '$Genitales', '$Extremidades', 
                '$SistemaNervioso', '$ProbablesDiagnostico', '$PlanEstudio', '$TerapeuticaInicial', 
                '$ObservacionesComentarios', '$Condicion', '$Pronostico'
            )";

    // Ejecutar la consulta SQL de inserción
    if ($conn->query($sql) === TRUE) {
        // Si la inserción es exitosa, se muestra una página con un mensaje de confirmación
        // y se pregunta si se desean agregar medicamentos
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
          <meta charset='UTF-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
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
              box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
              text-align: center;
              max-width: 400px;
              width: 90%;
            }
            .container p {
              font-size: 18px;
              margin: 15px 0;
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
              text-decoration: none;
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
            form {
              display: inline-block;
              margin: 0;
            }
          </style>
        </head>
        <body>
          <div class='container'>
            <p>Los datos se han registrado correctamente.</p>
            <p>¿Desea agregar medicamentos?</p>
            <form action='MedicamentosUsReg.html' method='GET'>
              <input type='hidden' name='paciente_curp' value='$paciente_curp'>
              <button type='submit' name='action' value='agregar' class='btn'>Agregar medicamentos</button>
            </form>
            <form action='Buscar.php' method='GET'>
              <button type='submit' class='btn btn-secondary'>No agregar medicamentos</button>
            </form>
          </div>
        </body>
        </html>";
    } else {
        // En caso de error en la inserción, se muestra un mensaje descriptivo
        echo "Error al registrar ficha: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos para liberar recursos
    $conn->close();
}
?>
