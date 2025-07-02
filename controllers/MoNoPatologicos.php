<?php


// ------------------------
//  Conexión a la Base de Datos
// ------------------------
$servername = "localhost";    // Servidor de base de datos
$username   = "root";         // Usuario de la base de datos
$password   = "";             // Contraseña del usuario
$dbname     = "clinica";      // Nombre de la base de datos

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
        // Captura de los datos enviados desde el formulario HTML
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
        $añofarmaco  = $_POST['AñoFarmaco'];

        // Asignar valor "No" si algunos campos opcionales vienen vacíos
        if (empty($tabaquismo))   { $tabaquismo = "No"; }
        if (empty($exfumador))    { $exfumador = "No"; }
        if (empty($alcohol))      { $alcohol = "No"; }
        if (empty($exalcoholico)) { $exalcoholico = "No"; }
        if (empty($alergias))     { $alergias = "No"; }
        if (empty($farmacos))     { $farmacos = "No"; }

        // Actualización en la base de datos basada en la CURP de la sesión
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
            // Se puede redirigir o mostrar un mensaje de éxito
            
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
    $añofarmaco   = $row["añofarmaco"];
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
    <link rel="stylesheet" href="/DocControl/assets/css/estilos.css" />
    <title>Antecedentes Personales No Patológicos</title>
  </head>
  <body>
    <section class="container">
      <form method="POST" class="form" id="formulario">
        <h1 style="text-align: center;">Antecedentes Personales No Patológicos</h1>
        
        <!-- Campo de CURP: se muestra pero es de solo lectura -->
       
        
        <!-- Sección: Tabaquismo -->
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
        
        <!-- Sección: Fumadores -->
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
        
        <!-- Sección: Alcohol -->
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
        
        <!-- Sección: Ex Alcoholico -->
        <div class="column">
          <div class="input-box">
            <label>Ex Alcoholico (Si/No)</label>
            <input type="text" placeholder="Si o No" name="ExAlcoholico" value="<?php echo $exalcoholico; ?>" />
          </div>
        </div>
        
        <!-- Sección: Alergias -->
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
        
        <!-- Sección: Tipo de Sangre -->
        <div class="column">
          <div class="input-box">
            <label>Tipo de Sangre</label>
            <input type="text" placeholder="Ej: O, A, B, AB" name="TipoSangre" value="<?php echo $tiposangre; ?>" />
          </div>
        </div>
        
        <!-- Sección: Vivienda -->
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
        
        <!-- Sección: Fármacos -->
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
        
        <!-- Botones de envío -->
        <div class="column">
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
