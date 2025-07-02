<?php


// ------------------------
// Conexión a la Base de Datos
// ------------------------

// Parámetros de conexión
$servername = "localhost";    // Servidor de base de datos
$username = "root";           // Usuario de la base de datos
$password = "";               // Contraseña del usuario
$dbname = "clinica";          // Nombre de la base de datos

// Establecer la conexión utilizando mysqli
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión; si falla, se detiene la ejecución mostrando el error.
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// ------------------------
// 2. Manejo de Sesión y Obtención de la CURP
// ------------------------

// Iniciar la sesión para acceder a las variables de sesión
session_start();

// Recuperar la CURP del paciente almacenada en la sesión.
// Si no existe, se asigna una cadena vacía.
$curp = isset($_SESSION['curp']) ? $_SESSION['curp'] : '';

// ------------------------
// 3. Procesamiento del Formulario
// ------------------------

// Verificar si se ha enviado alguna acción a través del formulario
if (isset($_POST['action'])) {
    
    // Acción: Actualizar datos
    if ($_POST['action'] === 'actualizar') {

        // Captura de los datos enviados desde el formulario HTML
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

        // Asignar valor "No" en caso de que algún campo opcional esté vacío.
        if (empty($diabetes_opc)) {
            $diabetes_opc = "No";
        }
        if (empty($cancer_opc)) {
            $cancer_opc = "No";
        }
        if (empty($nefropatas_opc)) {
            $nefropatas_opc = "No";
        }
        if (empty($cardiopatas_opc)) {
            $cardiopatas_opc = "No";
        }
        if (empty($hipertension_opc)) {
            $hipertension_opc = "No";
        }
        if (empty($malformaciones_opc)) {
            $malformaciones_opc = "No";
        }
        if (empty($otro_opc)) {
            $otro_opc = "No";
        }
        
        // Construcción de la consulta SQL para actualizar los antecedentes heredofamiliares.
        // Se actualizan todos los campos basándose en la CURP del paciente.
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
        
        // Ejecución de la consulta SQL; se notifica en caso de error.
        if (mysqli_query($conn, $sql)) {
            // Actualización exitosa: se puede incluir una redirección o mensaje de éxito.
        } else {
            echo "Error al actualizar los datos del paciente: " . mysqli_error($conn);
        }
   
    // Acción: Salir (redirección a otra página)
    } elseif ($_POST['action'] === 'Salir') {
        header("Location:/DocControl/views/FormulariosEditables.html");
        exit;
    }
}

// ------------------------
// 4. Consulta de Datos Existentes del Paciente
// ------------------------

// Verificar que se haya obtenido la CURP; de lo contrario, se muestra un error.
if (!empty($curp)) {
    // Consulta SQL para recuperar los antecedentes heredofamiliares asociados a la CURP.
    $sql = "SELECT * FROM datos_heredofamiliares WHERE paciente_curp = '$curp'";
    $result = mysqli_query($conn, $sql);

    // Si se encuentra un registro, se almacenan los datos en variables para prellenar el formulario.
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
        // En caso de no encontrar el registro correspondiente a la CURP,
        // se muestra un mensaje de error y se detiene la ejecución.
        echo "No se encontró ningún registro con el CURP proporcionado.";
        exit();
    }
} else {
    // Si la CURP no fue establecida en la sesión, se muestra un mensaje de error.
    echo "No se proporcionó la CURP en la sesión.";
    exit();
}
?>

<!-- ============================================================================
     A partir de aquí se inicia la sección HTML que muestra el formulario
     con los datos recuperados, permitiendo al usuario visualizarlos y actualizarlos.
============================================================================ -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Metadatos esenciales -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!-- Enlace a la hoja de estilos para el formulario -->
    <link rel="stylesheet" href="/DocControl/assets/css/estilos.css" />
    <title>Antecedentes Heredofamiliares</title>
  </head>
<body>
    <section class="container">
    <!-- Formulario para actualizar o salir, utilizando el método POST -->
    <form method="POST" class="form" id="formulario">
       
    <h1 style="text-align: center;">Antecedentes Heredofamiliares</h1>
      
      <!-- ============================
           Sección: Diabetes
      ============================ -->
      <div class="column">     
        <div class="input-box">
          <label>Diabetes</label>
          <!-- Campo para indicar la presencia de diabetes: "Si" o "No" -->
          <input type="text" placeholder="Si o No" id="DiabetesOpc" name="DiabetesOPC" value="<?php echo $diabetes_opc; ?>"  />
        </div> 
        <div class="input-box">
          <label>¿Quien?</label>
          <!-- Campo para especificar qué familiares tienen antecedentes de diabetes -->
          <input type="text" placeholder="Ingrese los familiares" id="DiabetesFamilia" name="DiabetesFamilia"  value="<?php echo $diabetes_familia; ?>" />
        </div>
      </div>

      <!-- ============================
           Sección: Cáncer
      ============================ -->
      <div class="column">
        <div class="input-box">
          <label>Cancer</label>
          <input type="text" placeholder="Si o No" name="CancerOpc" value="<?php echo $cancer_opc; ?>"/>
        </div>
        <div class="input-box">
          <label>¿Quien?</label>
          <input type="text" placeholder="Ingrese los familiares" name="CancerFamilia" value="<?php echo $cancer_familia; ?>"/>
          <!-- Campo adicional para especificar el tipo de cáncer -->
          <input type="text" placeholder="Ingrese el tipo"  name="CancerTipo"  value="<?php echo $cancer_tipo; ?>">
        </div>
      </div>

      <!-- ============================
           Sección: Nefropatías
      ============================ -->
      <div class="column">  
        <div class="input-box">
          <label>Nefropatas</label>
          <input type="text" placeholder="Si o No" name="NefropatasOpc" value="<?php echo $nefropatas_opc; ?>"/>
        </div> 
        <div class="input-box">
          <label>¿Quien?</label>
          <input type="text" placeholder="Ingrese los familiares" name="NefropatasFamilia" value="<?php echo $nefropatas_familia; ?>"  />
        </div>
      </div>

      <!-- ============================
           Sección: Cardiopatías
      ============================ -->
      <div class="column">  
        <div class="input-box">
          <label>Cardiopatas</label>
          <input type="text" placeholder="Si o No" name="CardiopatasOpc" value="<?php echo $cardiopatas_opc; ?>" />       
        </div>
        <div class="input-box">
          <label>¿Quien?</label>
          <input type="text" placeholder="Ingrese los familiares" name="CardiopatasFamilia"  value="<?php echo $cardiopatas_familia; ?>" />
        </div>
      </div>

      <!-- ============================
           Sección: Hipertensión Arterial
      ============================ -->
      <div class="column">  
        <div class="input-box">
          <label>Hipertención Arterial</label>
          <input type="text" placeholder="Si o No" name="HipertensionOpc" value="<?php echo $hipertension_opc; ?>" />
        </div>
        <div class="input-box">
          <label>¿Quien?</label>
          <input type="text" placeholder="Ingrese los familiares"  name="HipertensionFamilia" value="<?php echo $hipertension_familia; ?>" />
        </div>
      </div>

      <!-- ============================
           Sección: Malformaciones
      ============================ -->
      <div class="column">  
        <div class="input-box">
          <label>Malformaciones</label>
          <input type="text" placeholder="Si o No" name="MalformacionesOpc" value="<?php echo $malformaciones_opc; ?>" />
        </div>
        <div class="input-box">
          <label>¿Quien?</label>
          <input type="text" placeholder="Ingrese los familiares" name="MalformacionesFamilia" value="<?php echo $malformaciones_familia; ?>" />
        </div>
        <div class="input-box">
          <label>¿Tipo de malformaciones?</label>
          <input type="text" placeholder="Ingrese el tipo" name="MalformacionesTipo" value="<?php echo $malformaciones_tipo; ?>" />
        </div>
      </div>

      <!-- ============================
           Sección: Otros Antecedentes
      ============================ -->
      <div class="column">  
        <div class="input-box">
          <label>Otro</label>
          <input type="text" placeholder="Si o No" name="OtroOpc" value="<?php echo $otro_opc; ?>" />
        </div>
        <div class="input-box">
          <label>¿Quien?</label>
          <input type="text" placeholder="Ingrese los familiares" name="OtroFamilia" value="<?php echo $otro_familia; ?>" />
        </div>
        <div class="input-box">
          <label>¿Tipo?</label>
          <input type="text" placeholder="Ingrese el tipo" name="OtroTipo" value="<?php echo $otro_tipo; ?>" />
        </div>
      </div>

      <!-- ============================
           Botones de Envío
      ============================ -->
      <div class="column">
        <!-- Botón para actualizar los datos -->
        <button type="submit" name="action" value="actualizar">Actualizar</button>
        <!-- Botón para salir y redirigir a otra página -->
        <button type="submit" name="action" value="Salir">Regresar</button>
      </div>

    </form>
    </section>
</body>
</html>
