<?php
// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

session_start(); // Iniciar la sesión

// Obtener el valor de la CURP de la sesión
$curp = isset($_SESSION['curp']) ? $_SESSION['curp'] : '';

// Obtener la fecha de la visita de la URL
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';

if (!empty($curp) && !empty($fecha)) {
    // Consultar la base de datos para recuperar la información del paciente en la fecha especificada
    $sql = "SELECT * FROM fichaclinica WHERE paciente_curp = '$curp' AND fecha = '$fecha'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Si se encontró un registro con el CURP y fecha especificados, almacenar los valores en variables
        $row = mysqli_fetch_assoc($result);
        // Obtener los valores del formulario
        $fecha = $row["fecha"];
        $MoIngreso = $row["MoIngreso"];
        $PriEvo = $row["PriEvo"];
        $ResCardio = $row["ResCardio"];
        $Digestivo = $row["Digestivo"];
        $Endocrino = $row["Endocrino"];
        $MusEsqueletico = $row["MusEsqueletico"];
        $GenitoUrinario = $row["GenitoUrinario"];
        $PielAnexos = $row["PielAnexos"];
        $Neuropsiquiatrico = $row["Neuropsiquiatrico"];
        $TA = $row["TA"];
        $Pulso = $row["Pulso"];
        $Temperatura = $row["Temperatura"];
        $Peso = $row["Peso"];
        $Talla = $row["Talla"];
        $HabitusExterior = $row["HabitusExterior"];
        $CabezaCuello = $row["CabezaCuello"];
        $Torax = $row["Torax"];
        $Abdomen = $row["Abdomen"];
        $Genitales = $row["Genitales"];
        $Extremidades = $row["Extremidades"];
        $SistemaNervioso = $row["SistemaNervioso"];
        $ProbablesDiagnostico = $row["ProbablesDiagnostico"];
        $PlanEstudio = $row["PlanEstudio"];
        $TerapeuticaInicial = $row["TerapeuticaInicial"];
        $ObservacionesComentarios = $row["ObservacionesComentarios"];
        $Condicion = $row["Condicion"];
        $Pronostico = $row["Pronostico"];
    } else {
        // Si no se encontró ningún registro con el CURP y fecha especificados, mostrar un mensaje adecuado
        echo "No se encontró ningún registro con el CURP y fecha proporcionados.";
        exit();
    }
} else {
    // Si no se proporcionó la CURP o la fecha, mostrar un mensaje adecuado
    echo "No se proporcionó la CURP o la fecha.";
    exit();
}

// Aquí puedes mostrar el formulario con los valores obtenidos

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="/DocControl/assets/estilos.css" />
  </head>
  <body>
    <section class="container">
      <form method="POST" class="form" id="formulario">
        <h1 style="text-align: center;">Visita</h1>
        <div class="input-box">

        <label>Fecha</label>
          <input  type="date" value="<?php echo $fecha; ?>" readonly/>
        </div>

        <div class="input-box">
          <label>Motivo de ingreso</label>
          <input  type="text" value="<?php echo $MoIngreso; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Principio y Evolución del Padecimiento Actual</label>
          <input type="text"   value="<?php echo $PriEvo; ?>" readonly/>
        </div>
        <div class="input-box">
          <h1 style="text-align: center;">Interrogatorio por Aparatos y Sistemas</h1>
        </div>
        <div class="input-box">
          <label>Respiratorio / Cardiovascular:</label>
          <input type="text"  value="<?php echo $ResCardio; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Digestivo:</label>
          <input type="text"  value="<?php echo $Digestivo; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Endocrino:</label>
          <input type="text"  value="<?php echo $Endocrino; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Musculo-Esquelético:</label>
          <input type="text"  value="<?php echo $MusEsqueletico; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Genito-Urinario</label>
          <input type="text"   value="<?php echo $GenitoUrinario; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Piel y Anexos:</label>
          <input type="text"  value="<?php echo $PielAnexos; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Neurológico y Psiquiátrico</label>
          <input type="text" value="<?php echo $Neuropsiquiatrico; ?>" readonly/>
        </div>
        <div class="input-box">
          <h1 style="text-align: center;">Ficha clínica</h1>
        </div>
        <div class="column">
          <div class="input-box">
            <label>TA:</label>
            <input  type="text" value="<?php echo $TA; ?>" readonly/>
          </div>
          <div class="input-box">
            <label>FC/Pulso:</label>
            <input type="number"  value="<?php echo $Pulso; ?>" readonly/>
          </div>
          <div class="input-box">
            <label>Temp:</label>
            <input type="number"value="<?php echo $Temperatura; ?>" readonly/>
          </div>
          <div class="input-box">
            <label>Peso:</label>
            <input type="number"   value="<?php echo $Peso; ?>" readonly/>
          </div>
          <div class="input-box">
            <label>Talla:</label>
            <input type="number"  value="<?php echo $Talla; ?>" readonly/>
          </div>
        </div>
        <div class="input-box">
          <label>Habitus Exterior:</label>
          <input type="text"   value="<?php echo $HabitusExterior; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Cabeza y Cuello:</label>
          <input type="text"   value="<?php echo $CabezaCuello; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Toráx:</label>
          <input type="text"  value="<?php echo $Torax; ?>" readonly />
        </div>
        <div class="input-box">
          <label>Abdomen:</label>
          <input type="text"   value="<?php echo $Abdomen; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Genitales:</label>
          <input type="text"  value="<?php echo $Genitales; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Extremidades:</label>
          <input type="text"  value="<?php echo $Extremidades; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Sistema Nervioso:</label>
          <input type="text"   value="<?php echo $SistemaNervioso; ?>" readonly />
        </div>
        <div class="input-box"></div>
        <h1 style="text-align: center;">Análisis, Integración y Terapéutica</h1>
        <div class="input-box">
          <label>Probables Diagnóstico:</label>
          <input type="text"  value="<?php echo $ProbablesDiagnostico; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Plan de Estudio:</label>
          <input type="text"   value="<?php echo $PlanEstudio; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Terapéutica Inicial:</label>
          <input type="text"   value="<?php echo $TerapeuticaInicial; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Observaciones y/o Comentarios Finales:</label>
          <input type="text"  value="<?php echo $ObservacionesComentarios; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Condición:</label>
          <input type="text"   value="<?php echo $Condicion; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Pronóstico:</label>
          <input type="text" value="<?php echo $Pronostico; ?>" readonly/>
        </div>
        <button type="button" onclick="window.location.href = '/DocControl/controllers/Buscar.php?curp=<?php echo urlencode($curp); ?>'">Regresar</button>
      </form>
    </section>
  </body>
</html>
