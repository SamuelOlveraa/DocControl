<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Conexión fallida: " . mysqli_connect_error());
}

session_start();
$curp = isset($_SESSION['curp']) ? $_SESSION['curp'] : '';
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';

if (!empty($curp) && !empty($fecha)) {
  $sql = "SELECT * FROM fichaclinica WHERE paciente_curp = '$curp' AND fecha = '$fecha'";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    foreach ($row as $key => $value) {
      $$key = $value;
    }
  } else {
    echo "No se encontró ningún registro con el CURP y fecha proporcionados.";
    exit();
  }
} else {
  echo "No se proporcionó la CURP o la fecha.";
  exit();
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Visita Médica</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap">
  <style>
    /* FUENTE Y RESET */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

    /* FONDO ANIMADO */
    body {
      height: 100vh;
      background: linear-gradient(-45deg, #e0f7fa, #f0f9ff, #e8f0fe, #f3f4f6);
      background-size: 400% 400%;
      animation: gradientBackground 18s ease infinite;
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

    /* CONTENEDOR */
    .container {
      background: #ffffff;
      max-width: 800px;
      width: 100%;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      overflow-y: auto;
      max-height: 90vh;
    }

    .container:hover {
      box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
    }

    header {
      font-size: 2rem;
      font-weight: 700;
      color: #1a2537;
      text-align: center;
      margin-bottom: 30px;
    }

    .form {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .input-box label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: #2c3e50;
      font-size: 0.95rem;
    }

    .input-box input {
      width: 100%;
      padding: 14px 18px;
      border: 1px solid #cbd5e1;
      border-radius: 10px;
      background: #f9fafb;
      font-size: 1rem;
      color: #1f2937;
      transition: all 0.3s ease;
    }

    .input-box input:focus {
      border-color: #3b82f6;
      background-color: #fff;
      outline: none;
    }

    .button {
      background: linear-gradient(to right, #1a2537, #3b82f6);
      color: #ffffff;
      padding: 15px 20px;
      border: none;
      border-radius: 12px;
      font-size: 1.05rem;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 6px 12px rgba(59, 130, 246, 0.25);
      transition: all 0.3s ease-in-out;
    }

    .button:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(59, 130, 246, 0.4);
      background: linear-gradient(to right, #3b82f6, #1a2537);
    }

    .section-title {
      font-size: 1.2rem;
      font-weight: 700;
      color: #1a2537;
      margin: 18px 0 8px 0;
    }

    details summary {
      cursor: pointer;
      padding: 10px;
      background-color: #f3f4f6;
      border-radius: 10px;
      font-weight: 600;
      margin-top: 10px;
    }

    .column {
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
    }

    .column .input-box {
      flex: 1 1 120px;
      min-width: 120px;
    }

    @media (max-width: 600px) {
      .container { padding: 25px; }
      header { font-size: 1.5rem; }
    }
  </style>
</head>
<body>
  <section class="container">
    <header>Visita Médica</header>
    <form method="POST" class="form" id="formulario">

      <div class="input-box">
        <label>Fecha</label>
        <input type="date" value="<?php echo $fecha; ?>" readonly/>
      </div>

      <details open>
        <summary>Motivo y Evolución</summary>
        <div class="input-box">
          <label>Motivo de ingreso</label>
          <input type="text" value="<?php echo $MoIngreso; ?>" readonly/>
        </div>
        <div class="input-box">
          <label>Principio y Evolución del Padecimiento</label>
          <input type="text" value="<?php echo $PriEvo; ?>" readonly/>
        </div>
      </details>

      <details>
        <summary>Interrogatorio por Aparatos</summary>
        <?php
        $sistemas = [
          "ResCardio" => "Respiratorio / Cardiovascular",
          "Digestivo" => "Digestivo",
          "Endocrino" => "Endocrino",
          "MusEsqueletico" => "Músculo-Esquelético",
          "GenitoUrinario" => "Genito-Urinario",
          "PielAnexos" => "Piel y Anexos",
          "Neuropsiquiatrico" => "Neurológico y Psiquiátrico"
        ];
        foreach ($sistemas as $campo => $etiqueta) {
          echo "<div class='input-box'><label>$etiqueta</label><input type='text' value='" . $$campo . "' readonly/></div>";
        }
        ?>
      </details>

      <details>
        <summary>Exploración Física</summary>
        <div class="column">
          <?php
          foreach (["TA", "Pulso", "Temperatura", "Peso", "Talla"] as $campo) {
            echo "<div class='input-box'><label>$campo</label><input type='text' value='" . $$campo . "' readonly/></div>";
          }
          ?>
        </div>
        <?php
        $examen = [
          "HabitusExterior" => "Habitus Exterior",
          "CabezaCuello" => "Cabeza y Cuello",
          "Torax" => "Tórax",
          "Abdomen" => "Abdomen",
          "Genitales" => "Genitales",
          "Extremidades" => "Extremidades",
          "SistemaNervioso" => "Sistema Nervioso"
        ];
        foreach ($examen as $campo => $etiqueta) {
          echo "<div class='input-box'><label>$etiqueta</label><input type='text' value='" . $$campo . "' readonly/></div>";
        }
        ?>
      </details>

      <details>
        <summary>Diagnóstico y Plan</summary>
        <?php
        $plan = [
          "ProbablesDiagnostico" => "Diagnóstico(s)",
          "PlanEstudio" => "Plan de Estudio",
          "TerapeuticaInicial" => "Terapéutica Inicial",
          "ObservacionesComentarios" => "Observaciones / Comentarios",
          "Condicion" => "Condición",
          "Pronostico" => "Pronóstico"
        ];
        foreach ($plan as $campo => $etiqueta) {
          echo "<div class='input-box'><label>$etiqueta</label><input type='text' value='" . $$campo . "' readonly/></div>";
        }
        ?>
      </details>

      <button type="button" class="button" onclick="window.location.href = '/DocControl/controllers/Buscar.php?curp=<?php echo urlencode($curp); ?>'">
        Regresar
      </button>

    </form>
  </section>
</body>
</html>
