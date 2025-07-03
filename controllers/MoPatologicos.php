<?php
// ------------------------
// Conexión y Sesión
// ------------------------
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) die("Conexión fallida: " . mysqli_connect_error());

session_start();
$curp = $_SESSION['curp'] ?? '';

if (isset($_POST['action'])) {
    if ($_POST['action'] === 'actualizar') {
        $campos = [
            'enfermedadesInfancia', 'secuelasInfancia', 'hospitalizacionesPrevias',
            'especificacionHospitalizaciones', 'antecedentesQuirurgicos', 'especificacionQuirurgicos',
            'transfusionesPrevias', 'especificacionTransfusiones', 'fracturas',
            'especificacionFracturas', 'traumatismos', 'especificacionTraumatismos',
            'otraEnfermedad', 'especificacionOtraEnfermedad'
        ];
        $datos = array_map(fn($campo) => $_POST[$campo] ?? '', $campos);

        $sql = "UPDATE antecedentes_personales_patologicos SET 
                enfermedades_infancia = '$datos[0]', secuelas_infancia = '$datos[1]',
                hospitalizaciones_previas = '$datos[2]', especificacion_hospitalizaciones = '$datos[3]',
                antecedentes_quirurgicos = '$datos[4]', especificacion_quirurgicos = '$datos[5]',
                transfusiones_previas = '$datos[6]', especificacion_transfusiones = '$datos[7]',
                fracturas = '$datos[8]', especificacion_fracturas = '$datos[9]',
                traumatismos = '$datos[10]', especificacion_traumatismos = '$datos[11]',
                otra_enfermedad = '$datos[12]', especificacion_otra_enfermedad = '$datos[13]'
                WHERE paciente_curp = '$curp'";
        mysqli_query($conn, $sql) or die("Error al actualizar: " . mysqli_error($conn));
    } elseif ($_POST['action'] === 'Salir') {
        header("Location:/DocControl/views/FormulariosEditables.html");
        exit;
    }
}

$valores = array_fill_keys([
    'enfermedades_infancia', 'secuelas_infancia', 'hospitalizaciones_previas',
    'especificacion_hospitalizaciones', 'antecedentes_quirurgicos', 'especificacion_quirurgicos',
    'transfusiones_previas', 'especificacion_transfusiones', 'fracturas',
    'especificacion_fracturas', 'traumatismos', 'especificacion_traumatismos',
    'otra_enfermedad', 'especificacion_otra_enfermedad'
], "");

if ($curp) {
    $sql = "SELECT * FROM antecedentes_personales_patologicos WHERE paciente_curp = '$curp'";
    $res = mysqli_query($conn, $sql);
    if ($res && mysqli_num_rows($res) > 0) $valores = mysqli_fetch_assoc($res);
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Actualizar Antecedentes</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
    body {
      background: linear-gradient(-45deg, #e0f7fa, #f0f9ff, #e8f0fe, #f3f4f6);
      background-size: 400% 400%;
      animation: gradientBackground 18s ease infinite;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
    }
    @keyframes gradientBackground {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    .container {
      background: #ffffff;
      max-width: 900px;
      width: 100%;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    .container h1 {
      font-size: 2rem;
      font-weight: 700;
      color: #1a2537;
      text-align: center;
      margin-bottom: 30px;
    }
    .column {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 20px;
    }
    .col {
      flex: 1 1 300px;
    }
    .input-box label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: #2c3e50;
    }
    .input-box textarea,
    .input-box input[type="text"] {
      width: 100%;
      padding: 14px 18px;
      border: 1px solid #cbd5e1;
      border-radius: 10px;
      background: #f9fafb;
      font-size: 1rem;
    }
    .input-box input[type="radio"] {
      margin-right: 6px;
    }
    .form button {
      background: linear-gradient(to right, #1a2537, #3b82f6);
      color: #ffffff;
      padding: 14px 28px;
      border-radius: 12px;
      border: none;
      font-weight: 600;
      cursor: pointer;
      margin-right: 10px;
      transition: all 0.3s ease-in-out;
    }
    .form button:hover {
      transform: translateY(-2px);
      background: linear-gradient(to right, #3b82f6, #1a2537);
    }
    .acciones {
      text-align: center;
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <div class="container">
    <form class="form" method="POST">
      <h1>Actualizar Antecedentes Patológicos</h1>

      <?php
      function inputRadio($name, $valor) {
          return "
          <div class='col input-box'>
            <label>" . ucfirst(str_replace('_', ' ', $name)) . ":</label>
            <label><input type='radio' name='$name' value='si' " . ($valor=="si" ? "checked" : "") . ">Sí</label>
            <label><input type='radio' name='$name' value='no' " . ($valor=="no" ? "checked" : "") . ">No</label>
          </div>";
      }

      function inputText($name, $valor, $label=null) {
          $etiqueta = $label ?? ucfirst(str_replace('_', ' ', $name));
          return "<div class='col input-box'><label>$etiqueta:</label><input type='text' name='$name' value=\"$valor\"></div>";
      }

      function textareaBox($name, $valor, $label) {
          return "<div class='col input-box'><label>$label:</label><textarea name='$name'>$valor</textarea></div>";
      }

      echo "<div class='column'>".
            textareaBox("enfermedadesInfancia", $valores['enfermedades_infancia'], "Enfermedades en la infancia") .
            textareaBox("secuelasInfancia", $valores['secuelas_infancia'], "Secuelas en la infancia") .
          "</div>";

      echo "<div class='column'>".
            inputRadio("hospitalizacionesPrevias", $valores['hospitalizaciones_previas']) .
            inputText("especificacionHospitalizaciones", $valores['especificacion_hospitalizaciones']) .
          "</div>";

      echo "<div class='column'>".
            inputRadio("antecedentesQuirurgicos", $valores['antecedentes_quirurgicos']) .
            inputText("especificacionQuirurgicos", $valores['especificacion_quirurgicos']) .
          "</div>";

      echo "<div class='column'>".
            inputRadio("transfusionesPrevias", $valores['transfusiones_previas']) .
            inputText("especificacionTransfusiones", $valores['especificacion_transfusiones']) .
          "</div>";

      echo "<div class='column'>".
            inputRadio("fracturas", $valores['fracturas']) .
            inputText("especificacionFracturas", $valores['especificacion_fracturas']) .
          "</div>";

      echo "<div class='column'>".
            inputRadio("traumatismos", $valores['traumatismos']) .
            inputText("especificacionTraumatismos", $valores['especificacion_traumatismos']) .
          "</div>";

      echo "<div class='column'>".
            inputRadio("otraEnfermedad", $valores['otra_enfermedad']) .
            inputText("especificacionOtraEnfermedad", $valores['especificacion_otra_enfermedad']) .
          "</div>";
      ?>

      <div class="acciones">
        <button type="submit" name="action" value="actualizar">Actualizar</button>
        <button type="submit" name="action" value="Salir">Regresar</button>
      </div>
    </form>
  </div>
</body>
</html>
