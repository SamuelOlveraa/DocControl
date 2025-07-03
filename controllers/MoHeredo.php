<?php
// ------------------------
// Conexión a la Base de Datos
// ------------------------
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Conexión fallida: " . mysqli_connect_error());
}

// ------------------------
// Manejo de Sesión y Obtención de la CURP
// ------------------------
session_start();
$curp = isset($_SESSION['curp']) ? $_SESSION['curp'] : '';

// ------------------------
// Procesamiento del Formulario
// ------------------------
if (isset($_POST['action'])) {
  if ($_POST['action'] === 'actualizar') {
    $diabetes_opc         = $_POST['DiabetesOPC'];
    $diabetes_familia     = $_POST['DiabetesFamilia'];
    $cancer_opc           = $_POST['CancerOpc'];
    $cancer_familia       = $_POST['CancerFamilia'];
    $cancer_tipo          = $_POST['CancerTipo'];
    $nefropatas_opc       = $_POST['NefropatasOpc'];
    $nefropatas_familia   = $_POST['NefropatasFamilia'];
    $cardiopatas_opc      = $_POST['CardiopatasOpc'];
    $cardiopatas_familia  = $_POST['CardiopatasFamilia'];
    $hipertension_opc     = $_POST['HipertensionOpc'];
    $hipertension_familia = $_POST['HipertensionFamilia'];
    $malformaciones_opc   = $_POST['MalformacionesOpc'];
    $malformaciones_familia = $_POST['MalformacionesFamilia'];
    $malformaciones_tipo  = $_POST['MalformacionesTipo'];
    $otro_opc             = $_POST['OtroOpc'];
    $otro_familia         = $_POST['OtroFamilia'];
    $otro_tipo            = $_POST['OtroTipo'];

    if (empty($diabetes_opc)) $diabetes_opc = "No";
    if (empty($cancer_opc)) $cancer_opc = "No";
    if (empty($nefropatas_opc)) $nefropatas_opc = "No";
    if (empty($cardiopatas_opc)) $cardiopatas_opc = "No";
    if (empty($hipertension_opc)) $hipertension_opc = "No";
    if (empty($malformaciones_opc)) $malformaciones_opc = "No";
    if (empty($otro_opc)) $otro_opc = "No";

    $sql = "UPDATE datos_heredofamiliares SET 
        diabetes_opc='$diabetes_opc', 
        diabetes_familia='$diabetes_familia', 
        cancer_opc='$cancer_opc', 
        cancer_familia='$cancer_familia', 
        cancer_tipo='$cancer_tipo', 
        nefropatas_opc='$nefropatas_opc', 
        nefropatas_familia='$nefropatas_familia', 
        cardiopatas_opc='$cardiopatas_opc', 
        cardiopatas_familia='$cardiopatas_familia', 
        hipertension_opc='$hipertension_opc', 
        hipertension_familia='$hipertension_familia', 
        malformaciones_opc='$malformaciones_opc', 
        malformaciones_familia='$malformaciones_familia', 
        malformaciones_tipo='$malformaciones_tipo', 
        otro_opc='$otro_opc', 
        otro_familia='$otro_familia', 
        otro_tipo='$otro_tipo' 
        WHERE paciente_curp='$curp'";
    if (mysqli_query($conn, $sql)) {
      // Actualización exitosa
    } else {
      echo "Error al actualizar los datos del paciente: " . mysqli_error($conn);
    }
  } elseif ($_POST['action'] === 'Salir') {
    header("Location:/DocControl/views/FormulariosEditables.html");
    exit;
  }
}

// ------------------------
// Consulta de Datos Existentes del Paciente
// ------------------------
if (!empty($curp)) {
  $sql = "SELECT * FROM datos_heredofamiliares WHERE paciente_curp = '$curp'";
  $result = mysqli_query($conn, $sql);
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $diabetes_opc         = $row["diabetes_opc"];
    $diabetes_familia     = $row["diabetes_familia"];
    $cancer_opc           = $row["cancer_opc"];
    $cancer_familia       = $row["cancer_familia"];
    $cancer_tipo          = $row["cancer_tipo"];
    $nefropatas_opc       = $row["nefropatas_opc"];
    $nefropatas_familia   = $row["nefropatas_familia"];
    $cardiopatas_opc      = $row["cardiopatas_opc"];
    $cardiopatas_familia  = $row["cardiopatas_familia"];
    $hipertension_opc     = $row["hipertension_opc"];
    $hipertension_familia = $row["hipertension_familia"];
    $malformaciones_opc   = $row["malformaciones_opc"];
    $malformaciones_familia = $row["malformaciones_familia"];
    $malformaciones_tipo  = $row["malformaciones_tipo"];
    $otro_opc             = $row["otro_opc"];
    $otro_familia         = $row["otro_familia"];
    $otro_tipo            = $row["otro_tipo"];
  } else {
    echo "No se encontró ningún registro con el CURP proporcionado.";
    exit();
  }
} else {
  echo "No se proporcionó la CURP en la sesión.";
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Antecedentes Heredofamiliares</title>
  <style>
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
    margin-right: 10px;
  }
  .button:hover,
  .form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(59, 130, 246, 0.4);
    background: linear-gradient(to right, #3b82f6, #1a2537);
  }
  .form-row {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
  }
  .column {
    flex: 1 1 250px;
    min-width: 220px;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }
  @media (max-width: 600px) {
    .container { padding: 25px; }
    .container header { font-size: 1.5rem; }
    .form-row { flex-direction: column; gap: 0; }
  }
  .container:hover {
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
  }
  </style>
</head>
<body>
  <section class="container">
  <header>Antecedentes Heredofamiliares</header>
  <form method="POST" class="form" id="formulario">
    <div class="form-row">
    <div class="column">
      <div class="input-box">
      <label>Diabetes</label>
      <input type="text" placeholder="Si o No" id="DiabetesOpc" name="DiabetesOPC" value="<?php echo htmlspecialchars($diabetes_opc); ?>" />
      </div>
      <div class="input-box">
      <label>¿Quién?</label>
      <input type="text" placeholder="Ingrese los familiares" id="DiabetesFamilia" name="DiabetesFamilia" value="<?php echo htmlspecialchars($diabetes_familia); ?>" />
      </div>
    </div>
    <div class="column">
      <div class="input-box">
      <label>Cáncer</label>
      <input type="text" placeholder="Si o No" name="CancerOpc" value="<?php echo htmlspecialchars($cancer_opc); ?>"/>
      </div>
      <div class="input-box">
      <label>¿Quién?</label>
      <input type="text" placeholder="Ingrese los familiares" name="CancerFamilia" value="<?php echo htmlspecialchars($cancer_familia); ?>"/>
      </div>
      <div class="input-box">
      <label>¿Tipo de cáncer?</label>
      <input type="text" placeholder="Ingrese el tipo"  name="CancerTipo"  value="<?php echo htmlspecialchars($cancer_tipo); ?>">
      </div>
    </div>
    </div>
    <div class="form-row">
    <div class="column">
      <div class="input-box">
      <label>Nefropatías</label>
      <input type="text" placeholder="Si o No" name="NefropatasOpc" value="<?php echo htmlspecialchars($nefropatas_opc); ?>"/>
      </div>
      <div class="input-box">
      <label>¿Quién?</label>
      <input type="text" placeholder="Ingrese los familiares" name="NefropatasFamilia" value="<?php echo htmlspecialchars($nefropatas_familia); ?>"  />
      </div>
    </div>
    <div class="column">
      <div class="input-box">
      <label>Cardiopatías</label>
      <input type="text" placeholder="Si o No" name="CardiopatasOpc" value="<?php echo htmlspecialchars($cardiopatas_opc); ?>" />
      </div>
      <div class="input-box">
      <label>¿Quién?</label>
      <input type="text" placeholder="Ingrese los familiares" name="CardiopatasFamilia"  value="<?php echo htmlspecialchars($cardiopatas_familia); ?>" />
      </div>
    </div>
    </div>
    <div class="form-row">
    <div class="column">
      <div class="input-box">
      <label>Hipertensión Arterial</label>
      <input type="text" placeholder="Si o No" name="HipertensionOpc" value="<?php echo htmlspecialchars($hipertension_opc); ?>" />
      </div>
      <div class="input-box">
      <label>¿Quién?</label>
      <input type="text" placeholder="Ingrese los familiares"  name="HipertensionFamilia" value="<?php echo htmlspecialchars($hipertension_familia); ?>" />
      </div>
    </div>
    <div class="column">
      <div class="input-box">
      <label>Malformaciones</label>
      <input type="text" placeholder="Si o No" name="MalformacionesOpc" value="<?php echo htmlspecialchars($malformaciones_opc); ?>" />
      </div>
      <div class="input-box">
      <label>¿Quién?</label>
      <input type="text" placeholder="Ingrese los familiares" name="MalformacionesFamilia" value="<?php echo htmlspecialchars($malformaciones_familia); ?>" />
      </div>
      <div class="input-box">
      <label>¿Tipo de malformaciones?</label>
      <input type="text" placeholder="Ingrese el tipo" name="MalformacionesTipo" value="<?php echo htmlspecialchars($malformaciones_tipo); ?>" />
      </div>
    </div>
    </div>
    <div class="form-row">
    <div class="column">
      <div class="input-box">
      <label>Otro</label>
      <input type="text" placeholder="Si o No" name="OtroOpc" value="<?php echo htmlspecialchars($otro_opc); ?>" />
      </div>
      <div class="input-box">
      <label>¿Quién?</label>
      <input type="text" placeholder="Ingrese los familiares" name="OtroFamilia" value="<?php echo htmlspecialchars($otro_familia); ?>" />
      </div>
      <div class="input-box">
      <label>¿Tipo?</label>
      <input type="text" placeholder="Ingrese el tipo" name="OtroTipo" value="<?php echo htmlspecialchars($otro_tipo); ?>" />
      </div>
    </div>
    </div>
    <div class="form-row" style="justify-content:center;">
    <button type="submit" name="action" value="actualizar">Actualizar</button>
    <button type="submit" name="action" value="Salir">Regresar</button>
    </div>
  </form>
  </section>
</body>
</html>
