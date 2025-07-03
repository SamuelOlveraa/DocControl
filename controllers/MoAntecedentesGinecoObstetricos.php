<?php
session_start();

if (!isset($_SESSION['paciente_curp'])) {
  die("No se ha iniciado sesión o no se encontró la CURP.");
}

$curp = $_SESSION['paciente_curp'];

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "clinica";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Conexión fallida: " . mysqli_connect_error());
}

// Procesamiento del Formulario
if (isset($_POST['action']) && $_POST['action'] === 'actualizar') {
  $menarca                = $_POST['Menarca'];
  $ritmo                  = $_POST['Ritmo'];
  $fechaUltimaMestruacion = $_POST['FechaUltimaMestruacion'];
  $ciclosRegulares        = $_POST['CiclosRegulares'];
  $polimenorrea           = $_POST['Polimenorrea'];
  $duracionPolimenorrea   = $_POST['DuracionPolimenorrea'];
  $hipermenorrea          = $_POST['Hipermenorrea'];
  $duracionHipermenorrea  = $_POST['DuracionHipermenorrea'];
  $dismenorrea            = $_POST['Dismenorrea'];
  $duracionDismenorrea    = $_POST['DuracionDismenorrea'];
  $incapacitante          = $_POST['Incapacitante'];
  $duracionIncapacitante  = $_POST['DuracionIncapacitante'];
  $ivsa                   = $_POST['IVSA'];
  $noParejasSexuales      = $_POST['NoParejasSexuales'];
  $g                      = $_POST['G'];
  $p                      = $_POST['P'];
  $a                      = $_POST['A'];
  $c                      = $_POST['C'];
  $fechaUltimaCitologia   = $_POST['FechaUltimaCitologia'];
  $resultadoCitologia     = $_POST['ResultadoCitologia'];
  $metodoPlanificacion    = $_POST['MetodoPlanificacion'];

  $sql = "UPDATE antecedentes_gineco_obstetricos SET 
        Menarca                = '$menarca',
        Ritmo                  = '$ritmo',
        FechaUltimaMestruacion = '$fechaUltimaMestruacion',
        CiclosRegulares        = '$ciclosRegulares',
        Polimenorrea           = '$polimenorrea',
        DuracionPolimenorrea   = '$duracionPolimenorrea',
        Hipermenorrea          = '$hipermenorrea',
        DuracionHipermenorrea  = '$duracionHipermenorrea',
        Dismenorrea            = '$dismenorrea',
        DuracionDismenorrea    = '$duracionDismenorrea',
        Incapacitante          = '$incapacitante',
        DuracionIncapacitante  = '$duracionIncapacitante',
        IVSA                   = '$ivsa',
        NoParejasSexuales      = '$noParejasSexuales',
        G                      = '$g',
        P                      = '$p',
        A                      = '$a',
        C                      = '$c',
        FechaUltimaCitologia   = '$fechaUltimaCitologia',
        ResultadoCitologia     = '$resultadoCitologia',
        MetodoPlanificacion    = '$metodoPlanificacion'
      WHERE paciente_curp = '$curp'";

  if (!mysqli_query($conn, $sql)) {
    echo "Error al actualizar los datos: " . mysqli_error($conn);
  }
}

// Consulta de Datos Existentes
$sql = "SELECT * FROM antecedentes_gineco_obstetricos WHERE paciente_curp = '$curp'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $menarca                = $row["Menarca"];
  $ritmo                  = $row["Ritmo"];
  $fechaUltimaMestruacion = $row["FechaUltimaMestruacion"];
  $ciclosRegulares        = $row["CiclosRegulares"];
  $polimenorrea           = $row["Polimenorrea"];
  $duracionPolimenorrea   = $row["DuracionPolimenorrea"];
  $hipermenorrea          = $row["Hipermenorrea"];
  $duracionHipermenorrea  = $row["DuracionHipermenorrea"];
  $dismenorrea            = $row["Dismenorrea"];
  $duracionDismenorrea    = $row["DuracionDismenorrea"];
  $incapacitante          = $row["Incapacitante"];
  $duracionIncapacitante  = $row["DuracionIncapacitante"];
  $ivsa                   = $row["IVSA"];
  $noParejasSexuales      = $row["NoParejasSexuales"];
  $g                      = $row["G"];
  $p                      = $row["P"];
  $a                      = $row["A"];
  $c                      = $row["C"];
  $fechaUltimaCitologia   = $row["FechaUltimaCitologia"];
  $resultadoCitologia     = $row["ResultadoCitologia"];
  $metodoPlanificacion    = $row["MetodoPlanificacion"];
} else {
  $menarca                = "";
  $ritmo                  = "";
  $fechaUltimaMestruacion = "";
  $ciclosRegulares        = "";
  $polimenorrea           = "";
  $duracionPolimenorrea   = "";
  $hipermenorrea          = "";
  $duracionHipermenorrea  = "";
  $dismenorrea            = "";
  $duracionDismenorrea    = "";
  $incapacitante          = "";
  $duracionIncapacitante  = "";
  $ivsa                   = "";
  $noParejasSexuales      = "";
  $g                      = "";
  $p                      = "";
  $a                      = "";
  $c                      = "";
  $fechaUltimaCitologia   = "";
  $resultadoCitologia     = "";
  $metodoPlanificacion    = "";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Antecedentes Gineco Obstetricos</title>
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
  .container:hover {
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
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
  .column {
    display: flex;
    gap: 16px;
    justify-content: flex-end;
    margin-top: 10px;
  }
  @media (max-width: 600px) {
    .container { padding: 25px; }
    .container header { font-size: 1.5rem; }
  }
  </style>
</head>
<body>
  <section class="container">
  <header>Editar Antecedentes Gineco Obstetricos</header>
  <form method="POST" class="form" id="formulario">
    <div class="input-box">
    <label>Menarca</label>
    <input type="number" name="Menarca" value="<?php echo $menarca; ?>" required />
    </div>
    <div class="input-box">
    <label>Ritmo</label>
    <input type="number" name="Ritmo" value="<?php echo $ritmo; ?>" required />
    </div>
    <div class="input-box">
    <label>Fecha Última Mestruación</label>
    <input type="date" name="FechaUltimaMestruacion" value="<?php echo $fechaUltimaMestruacion; ?>" required />
    </div>
    <div class="input-box">
    <label>Ciclos Regulares</label>
    <select name="CiclosRegulares" required>
      <option value="si" <?php if($ciclosRegulares=="si") echo "selected"; ?>>Si</option>
      <option value="no" <?php if($ciclosRegulares=="no") echo "selected"; ?>>No</option>
    </select>
    </div>
    <div class="input-box">
    <label>Polimenorrea</label>
    <select name="Polimenorrea" required>
      <option value="si" <?php if($polimenorrea=="si") echo "selected"; ?>>Si</option>
      <option value="no" <?php if($polimenorrea=="no") echo "selected"; ?>>No</option>
    </select>
    </div>
    <div class="input-box">
    <label>Duración Polimenorrea (días)</label>
    <input type="number" name="DuracionPolimenorrea" value="<?php echo $duracionPolimenorrea; ?>" />
    </div>
    <div class="input-box">
    <label>Hipermenorrea</label>
    <select name="Hipermenorrea" required>
      <option value="si" <?php if($hipermenorrea=="si") echo "selected"; ?>>Si</option>
      <option value="no" <?php if($hipermenorrea=="no") echo "selected"; ?>>No</option>
    </select>
    </div>
    <div class="input-box">
    <label>Duración Hipermenorrea (días)</label>
    <input type="number" name="DuracionHipermenorrea" value="<?php echo $duracionHipermenorrea; ?>" />
    </div>
    <div class="input-box">
    <label>Dismenorrea</label>
    <select name="Dismenorrea" required>
      <option value="si" <?php if($dismenorrea=="si") echo "selected"; ?>>Si</option>
      <option value="no" <?php if($dismenorrea=="no") echo "selected"; ?>>No</option>
    </select>
    </div>
    <div class="input-box">
    <label>Duración Dismenorrea (días)</label>
    <input type="number" name="DuracionDismenorrea" value="<?php echo $duracionDismenorrea; ?>" />
    </div>
    <div class="input-box">
    <label>¿Incapacitante?</label>
    <select name="Incapacitante" required>
      <option value="si" <?php if($incapacitante=="si") echo "selected"; ?>>Si</option>
      <option value="no" <?php if($incapacitante=="no") echo "selected"; ?>>No</option>
    </select>
    </div>
    <div class="input-box">
    <label>Duración Incapacitante (días)</label>
    <input type="number" name="DuracionIncapacitante" value="<?php echo $duracionIncapacitante; ?>" />
    </div>
    <div class="input-box">
    <label>IVSA</label>
    <input type="number" name="IVSA" value="<?php echo $ivsa; ?>" required />
    </div>
    <div class="input-box">
    <label>No Parejas Sexuales</label>
    <input type="number" name="NoParejasSexuales" value="<?php echo $noParejasSexuales; ?>" />
    </div>
    <div class="input-box">
    <label>G</label>
    <input type="number" name="G" value="<?php echo $g; ?>" required />
    </div>
    <div class="input-box">
    <label>P</label>
    <input type="number" name="P" value="<?php echo $p; ?>" required />
    </div>
    <div class="input-box">
    <label>A</label>
    <input type="number" name="A" value="<?php echo $a; ?>" required />
    </div>
    <div class="input-box">
    <label>C</label>
    <input type="number" name="C" value="<?php echo $c; ?>" required />
    </div>
    <div class="input-box">
    <label>Fecha Última Citología</label>
    <input type="date" name="FechaUltimaCitologia" value="<?php echo $fechaUltimaCitologia; ?>" required />
    </div>
    <div class="input-box">
    <label>Resultado Citología</label>
    <input type="text" name="ResultadoCitologia" value="<?php echo $resultadoCitologia; ?>" required />
    </div>
    <div class="input-box">
    <label>Método Planificación</label>
    <input type="text" name="MetodoPlanificacion" value="<?php echo $metodoPlanificacion; ?>" required />
    </div>
    <div class="column">
    <button type="submit" name="action" value="actualizar">Actualizar</button>
    <button type="button" onclick="window.location.href='/DocControl/views/FormulariosEditables.html'">Regresar</button>
    </div>
  </form>
  </section>
</body>
</html>
<?php
mysqli_close($conn);
?>
