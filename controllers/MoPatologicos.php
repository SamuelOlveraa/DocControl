<?php

// ------------------------
// Conexión a la Base de Datos
// ------------------------
$servername = "localhost";         // Servidor de la base de datos
$username   = "root";              // Usuario de la base de datos
$password   = "";                  // Contraseña (vacía en este ejemplo)
$dbname     = "clinica";           // Nombre de la base de datos

// Establecer la conexión usando mysqli
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// ------------------------
// 2. Manejo de Sesión y Obtención de la CURP
// ------------------------
session_start();
// Se recupera la CURP del paciente, utilizada para identificar el registro a actualizar.
$curp = isset($_SESSION['curp']) ? $_SESSION['curp'] : '';

// ------------------------
// 3. Procesamiento del Formulario (Actualización)
// ------------------------
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'actualizar') {
        // Capturar los valores enviados desde el formulario
        $enfermedades_infancia             = $_POST['enfermedadesInfancia'];
        $secuelas_infancia                 = $_POST['secuelasInfancia'];
        $hospitalizaciones_previas         = $_POST['hospitalizacionesPrevias'];
        $especificacion_hospitalizaciones  = $_POST['especificacionHospitalizaciones'];
        $antecedentes_quirurgicos          = $_POST['antecedentesQuirurgicos'];
        $especificacion_quirurgicos        = $_POST['especificacionQuirurgicos'];
        $transfusiones_previas             = $_POST['transfusionesPrevias'];
        $especificacion_transfusiones      = $_POST['especificacionTransfusiones'];
        $fracturas                         = $_POST['fracturas'];
        $especificacion_fracturas          = $_POST['especificacionFracturas'];
        $traumatismos                      = $_POST['traumatismos'];
        $especificacion_traumatismos       = $_POST['especificacionTraumatismos'];
        $otra_enfermedad                   = $_POST['otraEnfermedad'];
        $especificacion_otra_enfermedad    = $_POST['especificacionOtraEnfermedad'];

        // Construir la consulta SQL para actualizar el registro existente
        $sql = "UPDATE antecedentes_personales_patologicos SET 
                    enfermedades_infancia             = '$enfermedades_infancia',
                    secuelas_infancia                 = '$secuelas_infancia',
                    hospitalizaciones_previas         = '$hospitalizaciones_previas',
                    especificacion_hospitalizaciones  = '$especificacion_hospitalizaciones',
                    antecedentes_quirurgicos          = '$antecedentes_quirurgicos',
                    especificacion_quirurgicos        = '$especificacion_quirurgicos',
                    transfusiones_previas             = '$transfusiones_previas',
                    especificacion_transfusiones      = '$especificacion_transfusiones',
                    fracturas                         = '$fracturas',
                    especificacion_fracturas          = '$especificacion_fracturas',
                    traumatismos                      = '$traumatismos',
                    especificacion_traumatismos       = '$especificacion_traumatismos',
                    otra_enfermedad                   = '$otra_enfermedad',
                    especificacion_otra_enfermedad    = '$especificacion_otra_enfermedad'
                WHERE paciente_curp = '$curp'";
        
        if (mysqli_query($conn, $sql)) {
            // Registro actualizado correctamente.
        } else {
            echo "Error al actualizar los datos del paciente: " . mysqli_error($conn);
        }
    } elseif ($_POST['action'] === 'Salir') {
        header("Location:/DocControl/views/FormulariosEditables.html");
        exit;
    }
}

// ------------------------
// 4. Recuperación de Datos Existentes
// ------------------------
if (!empty($curp)) {
    $sql = "SELECT * FROM antecedentes_personales_patologicos WHERE paciente_curp = '$curp'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $enfermedades_infancia             = $row["enfermedades_infancia"];
        $secuelas_infancia                 = $row["secuelas_infancia"];
        $hospitalizaciones_previas         = $row["hospitalizaciones_previas"];
        $especificacion_hospitalizaciones  = $row["especificacion_hospitalizaciones"];
        $antecedentes_quirurgicos          = $row["antecedentes_quirurgicos"];
        $especificacion_quirurgicos        = $row["especificacion_quirurgicos"];
        $transfusiones_previas             = $row["transfusiones_previas"];
        $especificacion_transfusiones      = $row["especificacion_transfusiones"];
        $fracturas                         = $row["fracturas"];
        $especificacion_fracturas          = $row["especificacion_fracturas"];
        $traumatismos                      = $row["traumatismos"];
        $especificacion_traumatismos       = $row["especificacion_traumatismos"];
        $otra_enfermedad                   = $row["otra_enfermedad"];
        $especificacion_otra_enfermedad    = $row["especificacion_otra_enfermedad"];
    } else {
        // Inicializar variables en blanco (se espera que la CURP ya exista en actualización)
        $enfermedades_infancia             = "";
        $secuelas_infancia                 = "";
        $hospitalizaciones_previas         = "";
        $especificacion_hospitalizaciones  = "";
        $antecedentes_quirurgicos          = "";
        $especificacion_quirurgicos        = "";
        $transfusiones_previas             = "";
        $especificacion_transfusiones      = "";
        $fracturas                         = "";
        $especificacion_fracturas          = "";
        $traumatismos                      = "";
        $especificacion_traumatismos       = "";
        $otra_enfermedad                   = "";
        $especificacion_otra_enfermedad    = "";
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Actualizar Antecedentes Patológicos</title>
    <!-- Estilos internos para una distribución responsiva con Flexbox -->
    <style>
      .container {
        max-width: 900px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        background: #f9f9f9;
      }
      .row {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 15px;
      }
      .col {
        flex: 1;
        min-width: 250px;
        padding: 10px;
      }
      .input-box {
        margin-bottom: 10px;
      }
      label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
      }
      input[type="text"],
      textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
      }
      input[type="radio"] {
        margin-right: 5px;
      }
      button {
        padding: 10px 20px;
        margin-right: 10px;
      }
      .button-row {
        display: flex;
        justify-content: center;
      }
    </style>
    <!-- Se puede incluir una hoja de estilos externa si se requiere -->
    <link rel="stylesheet" href="/DocControl/assets/css/estilos.css" />
  </head>
<body>
  <section class="container">
    <form method="POST" class="form" id="formulario">
      <h1 style="text-align: center;">Actualizar Antecedentes Patológicos</h1>
      
      <!-- Fila 1: Enfermedades y Secuelas en la Infancia -->
      <div class="column">
        <div class="col">
          <div class="input-box">
            <label>Enfermedades en la infancia:</label>
            <textarea name="enfermedadesInfancia"><?php echo $enfermedades_infancia; ?></textarea>
          </div>
        </div>
        <div class="column">
          <div class="input-box">
            <label>Secuelas en la infancia:</label>
            <textarea name="secuelasInfancia"><?php echo $secuelas_infancia; ?></textarea>
          </div>
        </div>
      </div>
      
      <!-- Fila 2: Hospitalizaciones Previas y Especificación -->
      <div class="column">
        <div class="col">
          <div class="input-box">
            <label>Hospitalizaciones previas:</label>
            <!-- Radio buttons para campo enum: 'si' o 'no' -->
            <input type="radio" name="hospitalizacionesPrevias" value="si" <?php if ($hospitalizaciones_previas=="si") echo "checked"; ?>> Sí
            <input type="radio" name="hospitalizacionesPrevias" value="no" <?php if ($hospitalizaciones_previas=="no") echo "checked"; ?>> No
          </div>
        </div>
        <div class="col">
          <div class="input-box">
            <label>Especificación de hospitalizaciones:</label>
            <input type="text" name="especificacionHospitalizaciones" value="<?php echo $especificacion_hospitalizaciones; ?>">
          </div>
        </div>
      </div>
      
      <!-- Fila 3: Antecedentes Quirúrgicos y Especificación -->
      <div class="column">
        <div class="col">
          <div class="input-box">
            <label>Antecedentes quirúrgicos:</label>
            <input type="radio" name="antecedentesQuirurgicos" value="si" <?php if ($antecedentes_quirurgicos=="si") echo "checked"; ?>> Sí
            <input type="radio" name="antecedentesQuirurgicos" value="no" <?php if ($antecedentes_quirurgicos=="no") echo "checked"; ?>> No
          </div>
        </div>
        <div class="col">
          <div class="input-box">
            <label>Especificación quirúrgicos:</label>
            <input type="text" name="especificacionQuirurgicos" value="<?php echo $especificacion_quirurgicos; ?>">
          </div>
        </div>
      </div>
      
      <!-- Fila 4: Transfusiones Previas y Especificación -->
      <div class="column">
        <div class="col">
          <div class="input-box">
            <label>Transfusiones previas:</label>
            <input type="radio" name="transfusionesPrevias" value="si" <?php if ($transfusiones_previas=="si") echo "checked"; ?>> Sí
            <input type="radio" name="transfusionesPrevias" value="no" <?php if ($transfusiones_previas=="no") echo "checked"; ?>> No
          </div>
        </div>
        <div class="column">
          <div class="input-box">
            <label>Especificación transfusiones:</label>
            <input type="text" name="especificacionTransfusiones" value="<?php echo $especificacion_transfusiones; ?>">
          </div>
        </div>
      </div>
      
      <!-- Fila 5: Fracturas y Especificación -->
      <div class="column">
        <div class="col">
          <div class="input-box">
            <label>Fracturas:</label>
            <input type="radio" name="fracturas" value="si" <?php if ($fracturas=="si") echo "checked"; ?>> Sí
            <input type="radio" name="fracturas" value="no" <?php if ($fracturas=="no") echo "checked"; ?>> No
          </div>
        </div>
        <div class="col">
          <div class="input-box">
            <label>Especificación fracturas:</label>
            <input type="text" name="especificacionFracturas" value="<?php echo $especificacion_fracturas; ?>">
          </div>
        </div>
      </div>
      
      <!-- Fila 6: Traumatismos y Especificación -->
      <div class="column">
        <div class="col">
          <div class="input-box">
            <label>Traumatismos:</label>
            <input type="radio" name="traumatismos" value="si" <?php if ($traumatismos=="si") echo "checked"; ?>> Sí
            <input type="radio" name="traumatismos" value="no" <?php if ($traumatismos=="no") echo "checked"; ?>> No
          </div>
        </div>
        <div class="column">
          <div class="input-box">
            <label>Especificación traumatismos:</label>
            <input type="text" name="especificacionTraumatismos" value="<?php echo $especificacion_traumatismos; ?>">
          </div>
        </div>
      </div>
      
      <!-- Fila 7: Otra Enfermedad y Especificación -->
      <div class="column">
        <div class="col">
          <div class="input-box">
            <label>Otra enfermedad:</label>
            <input type="radio" name="otraEnfermedad" value="si" <?php if ($otra_enfermedad=="si") echo "checked"; ?>> Sí
            <input type="radio" name="otraEnfermedad" value="no" <?php if ($otra_enfermedad=="no") echo "checked"; ?>> No
          </div>
        </div>
        <div class="col">
          <div class="input-box">
            <label>Especificación otra enfermedad:</label>
            <input type="text" name="especificacionOtraEnfermedad" value="<?php echo $especificacion_otra_enfermedad; ?>">
          </div>
        </div>
      </div>
      
      <!-- Fila 8: Botones para Actualizar o Salir -->
      <div class="column">
        <button type="submit" name="action" value="actualizar">Actualizar</button>
        <button type="submit" name="action" value="Salir">Regresar</button>
      </div>
      
    </form>
  </section>
</body>
</html>
