<?php
// ------------------------
//  Conexión a la Base de Datos
// ------------------------
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "clinica";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Conexión fallida: " . mysqli_connect_error());
}

// ------------------------
// 2. Manejo de Sesión y Obtención de la CURP del Paciente
// ------------------------
session_start();
$curp = isset($_SESSION['curp']) ? $_SESSION['curp'] : '';

if (empty($curp)) {
  echo "No se proporcionó la CURP en la sesión.";
  exit();
}

// ------------------------
// 3. Procesamiento del Formulario
// ------------------------
if (isset($_POST['action'])) {
  if ($_POST['action'] === 'actualizar') {
    $tabaquismo   = $_POST['Tabaquismo'];
    $notabaco     = $_POST['Notabaco'];
    $añotabaco    = $_POST['Añotabaco'];
    $exfumador    = $_POST['ExFumador'];
    $fumadorpas   = $_POST['FumadorPas'];
    $alcohol      = $_POST['Alcohol'];
    $cantalcohol  = $_POST['Cantalcohol'];
    $añoalcohol   = $_POST['AñoAlcohol'];
    $exalcoholico = $_POST['ExAlcoholico'];
    $alergias     = $_POST['Alergias'];
    $espalergias  = $_POST['EspAlergias'];
    $tiposangre   = $_POST['TipoSangre'];
    $vivienda     = $_POST['Vivienda'];
    $otvivienda   = $_POST['OtVivienda'];
    $farmacos     = $_POST['Farmacos'];
    $añofarmaco   = $_POST['AñoFarmaco'];

    if (empty($tabaquismo))   { $tabaquismo = "No"; }
    if (empty($exfumador))    { $exfumador = "No"; }
    if (empty($alcohol))      { $alcohol = "No"; }
    if (empty($exalcoholico)) { $exalcoholico = "No"; }
    if (empty($alergias))     { $alergias = "No"; }
    if (empty($farmacos))     { $farmacos = "No"; }

    $sql = "UPDATE antecedentes_personales_no_patologicos SET 
          tabaquismo   = '$tabaquismo', 
          notabaco     = '$notabaco', 
          `añotabaco`  = '$añotabaco', 
          exfumador    = '$exfumador', 
          fumadorpas   = '$fumadorpas', 
          alcohol      = '$alcohol', 
          cantalcohol  = '$cantalcohol', 
          `añoalcohol` = '$añoalcohol', 
          exalcoholico = '$exalcoholico', 
          alergias     = '$alergias', 
          espalergias  = '$espalergias', 
          tiposangre   = '$tiposangre', 
          vivienda     = '$vivienda', 
          otvivienda   = '$otvivienda', 
          farmacos     = '$farmacos', 
          `añofarmaco` = '$añofarmaco'
        WHERE paciente_curp = '$curp'";

    if (mysqli_query($conn, $sql)) {
      // Mensaje de éxito opcional
    } else {
      echo "Error al actualizar los datos: " . mysqli_error($conn);
    }
  } elseif ($_POST['action'] === 'Salir') {
    header("Location:/DocControl/views/FormulariosEditables.html");
    exit;
  }
}

// ------------------------
// 4. Consulta de Datos Existentes del Paciente
// ------------------------
$sql = "SELECT * FROM antecedentes_personales_no_patologicos WHERE paciente_curp = '$curp'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $tabaquismo    = $row["tabaquismo"];
  $notabaco      = $row["notabaco"];
  $añotabaco     = $row["añotabaco"];
  $exfumador     = $row["exfumador"];
  $fumadorpas    = $row["fumadorpas"];
  $alcohol       = $row["alcohol"];
  $cantalcohol   = $row["cantalcohol"];
  $añoalcohol    = $row["añoalcohol"];
  $exalcoholico  = $row["exalcoholico"];
  $alergias      = $row["alergias"];
  $espalergias   = $row["espalergias"];
  $tiposangre    = $row["tiposangre"];
  $vivienda      = $row["vivienda"];
  $otvivienda    = $row["otvivienda"];
  $farmacos      = $row["farmacos"];
  $añofarmaco    = $row["añofarmaco"];
} else {
  echo "No se encontró ningún registro para la CURP proporcionada.";
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Antecedentes Personales No Patológicos</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap">
  <style>
    /* Copia aquí el CSS proporcionado por el usuario */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
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
    .container {
      background: #ffffff;
      max-width: 700px;
      width: 100%;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease-in-out;
    }
    .container header {
      font-size: 2rem;
      font-weight: 700;
      color: #1a2537;
      text-align: center;
      margin-bottom: 30px;
      letter-spacing: 0.5px;
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
    .input-box input,
    .input-box select,
    .input-box textarea {
      width: 100%;
      padding: 14px 18px;
      border: 1px solid #cbd5e1;
      border-radius: 10px;
      background: #f9fafb;
      font-size: 1rem;
      color: #1f2937;
      transition: all 0.3s ease;
    }
    .input-box input:focus,
    .input-box select:focus,
    .input-box textarea:focus {
      border-color: #3b82f6;
      background-color: #fff;
      outline: none;
    }
    textarea {
      resize: vertical;
      min-height: 100px;
    }
    .invalid {
      border: 2px solid #e63946 !important;
    }
    .genero-box { margin-top: 5px; }
    .genero {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
      margin-top: 8px;
    }
    .genero label {
      color: #4b5563;
      font-size: 0.95rem;
    }
    .genero input {
      accent-color: #3b82f6;
      cursor: pointer;
    }
    .button,
    .form button {
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
    .button:hover,
    .form button:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(59, 130, 246, 0.4);
      background: linear-gradient(to right, #3b82f6, #1a2537);
    }
    .link {
      text-decoration: none;
      color: #1a2537;
      font-weight: 600;
    }
    .link:hover {
      color: #3b82f6;
      text-decoration: underline;
    }
    @media (max-width: 600px) {
      .container { padding: 25px; }
      .container header { font-size: 1.5rem; }
    }
    .container:hover {
      box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
    }
    details {
      margin-bottom: 20px;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      background-color: #f8fafc;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      transition: all 0.3s ease-in-out;
      overflow: hidden;
    }
    details[open] {
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    details summary {
      padding: 16px 20px;
      font-size: 1.05rem;
      font-weight: 600;
      background: linear-gradient(to right, #e3edf8, #f1f5f9);
      color: #1e293b;
      cursor: pointer;
      border-bottom: 1px solid #cbd5e1;
      list-style: none;
      transition: background 0.3s ease;
    }
    details summary:hover {
      background: linear-gradient(to right, #dbeafe, #e0f2fe);
    }
    details .card {
      padding: 20px;
    }
    .card h3 {
      font-size: 1.1rem;
      font-weight: 700;
      margin-bottom: 12px;
      color: #1a2537;
      border-bottom: 1px solid #cbd5e1;
      padding-bottom: 4px;
    }
    .card .column {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
    }
    .card .input-box {
      flex: 1 1 180px;
      min-width: 160px;
    }
    textarea[readonly] {
      background-color: #f9fafb;
      border: 1px solid #cbd5e1;
      padding: 14px 18px;
      border-radius: 10px;
      font-size: 1rem;
      resize: vertical;
      min-height: 80px;
      overflow-y: auto;
      color: #1f2937;
    }
  </style>
</head>
<body>
  <section class="container">
    <header>Antecedentes Personales No Patológicos</header>
    <form method="POST" class="form" id="formulario">
    <!-- Agrupación en secciones modernas con <details> y .card -->
    <details open>
      <summary>Tabaquismo</summary>
      <div class="card">
      <div class="column">
        <div class="input-box">
        <label>Tabaquismo (Si/No)</label>
        <input type="text" placeholder="Si o No" name="Tabaquismo" value="<?php echo $tabaquismo; ?>" />
        </div>
        <div class="input-box">
        <label>No Tabaco (Cantidad)</label>
        <input type="number" placeholder="Ingrese cantidad" name="Notabaco" value="<?php echo $notabaco; ?>" />
        </div>
        <div class="input-box">
        <label>Año Tabaco</label>
        <input type="number" placeholder="Ingrese años" name="Añotabaco" value="<?php echo $añotabaco; ?>" />
        </div>
      </div>
      </div>
    </details>
    <details>
      <summary>Fumadores</summary>
      <div class="card">
      <div class="column">
        <div class="input-box">
        <label>Ex Fumador (Si/No)</label>
        <input type="text" placeholder="Si o No" name="ExFumador" value="<?php echo $exfumador; ?>" />
        </div>
        <div class="input-box">
        <label>Fumador Pasivo (Si/No)</label>
        <input type="text" placeholder="Si o No" name="FumadorPas" value="<?php echo $fumadorpas; ?>" />
        </div>
      </div>
      </div>
    </details>
    <details>
      <summary>Alcohol</summary>
      <div class="card">
      <div class="column">
        <div class="input-box">
        <label>Alcohol (Si/No)</label>
        <input type="text" placeholder="Si o No" name="Alcohol" value="<?php echo $alcohol; ?>" />
        </div>
        <div class="input-box">
        <label>Cantidad de Alcohol</label>
        <input type="number" placeholder="Ingrese cantidad" name="Cantalcohol" value="<?php echo $cantalcohol; ?>" />
        </div>
        <div class="input-box">
        <label>Año Alcohol</label>
        <input type="number" placeholder="Ingrese años" name="AñoAlcohol" value="<?php echo $añoalcohol; ?>" />
        </div>
      </div>
      <div class="column">
        <div class="input-box">
        <label>Ex Alcoholico (Si/No)</label>
        <input type="text" placeholder="Si o No" name="ExAlcoholico" value="<?php echo $exalcoholico; ?>" />
        </div>
      </div>
      </div>
    </details>
    <details>
      <summary>Alergias</summary>
      <div class="card">
      <div class="column">
        <div class="input-box">
        <label>Alergias (Si/No)</label>
        <input type="text" placeholder="Si o No" name="Alergias" value="<?php echo $alergias; ?>" />
        </div>
        <div class="input-box">
        <label>Especificar Alergias</label>
        <input type="text" placeholder="Detalle alergias" name="EspAlergias" value="<?php echo $espalergias; ?>" />
        </div>
      </div>
      </div>
    </details>
    <details>
      <summary>Tipo de Sangre</summary>
      <div class="card">
      <div class="column">
        <div class="input-box">
        <label>Tipo de Sangre</label>
        <input type="text" placeholder="Ej: O, A, B, AB" name="TipoSangre" value="<?php echo $tiposangre; ?>" />
        </div>
      </div>
      </div>
    </details>
    <details>
      <summary>Vivienda</summary>
      <div class="card">
      <div class="column">
        <div class="input-box">
        <label>Vivienda (Tipo)</label>
        <input type="text" placeholder="Si o No o Código" name="Vivienda" value="<?php echo $vivienda; ?>" />
        </div>
        <div class="input-box">
        <label>Otros en Vivienda</label>
        <input type="text" placeholder="Especifique" name="OtVivienda" value="<?php echo $otvivienda; ?>" />
        </div>
      </div>
      </div>
    </details>
    <details>
      <summary>Fármacos</summary>
      <div class="card">
      <div class="column">
        <div class="input-box">
        <label>Fármacos (Si/No)</label>
        <input type="text" placeholder="Si o No" name="Farmacos" value="<?php echo $farmacos; ?>" />
        </div>
        <div class="input-box">
        <label>Año Fármacos</label>
        <input type="number" placeholder="Ingrese años" name="AñoFarmaco" value="<?php echo $añofarmaco; ?>" />
        </div>
      </div>
      </div>
    </details>
    <div class="column" style="justify-content:center; gap:20px;">
      <button type="submit" name="action" value="actualizar">Actualizar</button>
      <button type="submit" name="action" value="Salir">Regresar</button>
    </div>
    </form>
  </section>
</body>
</html>
<?php
mysqli_close($conn);
?>
