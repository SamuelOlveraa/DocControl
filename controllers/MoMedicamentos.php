<?php
session_start();

// Verificar que exista el CURP en la sesión
if (!isset($_SESSION['paciente_curp'])) {
    die("No se encontró el CURP del paciente. Por favor, inicie sesión.");
}
$paciente_curp = $_SESSION['paciente_curp'];

// Conexión a la base de datos
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "clinica";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar la actualización si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'actualizar') {
    // Se reciben los datos como arrays
    $ids                = $_POST['medicamentoId'];
    $Nombres            = $_POST['NombreMedicamento'];
    $Activos            = $_POST['NombreActivo'];
    $Presentaciones     = $_POST['Presentacion'];
    $DosisArr           = $_POST['Dosis'];
    $Vias               = $_POST['Via'];
    $Fechas             = $_POST['FechaUlAdmin'];
    $Horas              = $_POST['HoraUlAdmin'];

    // Iterar por cada registro y actualizar
    for ($i = 0; $i < count($ids); $i++) {
        $id               = (int)$ids[$i];
        $NombreMedicamento= mysqli_real_escape_string($conn, $Nombres[$i]);
        $NombreActivo     = mysqli_real_escape_string($conn, $Activos[$i]);
        $Presentacion     = mysqli_real_escape_string($conn, $Presentaciones[$i]);
        $Dosis            = (int)$DosisArr[$i];
        $Via              = mysqli_real_escape_string($conn, $Vias[$i]);
        $FechaUlAdmin     = mysqli_real_escape_string($conn, $Fechas[$i]);
        $HoraUlAdmin      = mysqli_real_escape_string($conn, $Horas[$i]);

        $sql = "UPDATE Medicamentos SET 
                    NombreMedicamento = '$NombreMedicamento',
                    NombreActivo = '$NombreActivo',
                    Presentacion = '$Presentacion',
                    Dosis = $Dosis,
                    Via = '$Via',
                    FechaUlAdmin = '$FechaUlAdmin',
                    HoraUlAdmin = '$HoraUlAdmin'
                WHERE id = $id";
        mysqli_query($conn, $sql);
    }
    header("Location: ListaMeddicamentos.php");
    exit();
}

// Consultar la base de datos para obtener los medicamentos del paciente
$stmt = $conn->prepare("SELECT id, NombreMedicamento, NombreActivo, Presentacion, Dosis, Via, FechaUlAdmin, HoraUlAdmin 
                        FROM Medicamentos WHERE paciente_curp = ?");
$stmt->bind_param("s", $paciente_curp);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Medicamentos Consumidos</title>
  <link rel="stylesheet" href="/DocControl/assets/css/estilos.css">
  <style>
      .container {
          max-width: 900px;
          margin: 0 auto;
          padding: 20px;
      }
      h1 {
          text-align: center;
      }
      form#medForm {
          position: relative;
      }
      .med-item {
          border: 1px solid #ddd;
          padding: 15px;
          margin-bottom: 20px;
          border-radius: 8px;
      }
      .med-item .input-group {
          margin-bottom: 10px;
      }
      .med-item label {
          display: block;
          margin-bottom: 5px;
      }
      .med-item input {
          width: 100%;
          padding: 8px;
          box-sizing: border-box;
      }
      .actions {
          text-align: center;
          margin-top: 20px;
      }
      .actions .btn {
          padding: 10px 20px;
          border: none;
          border-radius: 4px;
          cursor: pointer;
          color: #fff;
          margin: 0 10px;
      }
      .btn-update {
          background-color: #007BFF;
      }
      .btn-update:hover {
          background-color: #0056b3;
      }
      .btn-back {
          background-color: #6c757d;
      }
      .btn-back:hover {
          background-color: #5a6268;
      }
  </style>
</head>
<body>
  <section class="container">
      <h1>Editar Medicamentos Consumidos</h1>
      <form id="medForm" action="" method="POST">
      <?php
      if ($result->num_rows > 0) {
          // Por cada medicamento, mostrar sus campos en forma de "item"
          while ($row = $result->fetch_assoc()) {
      ?>
          <div class="med-item">
              <!-- Campo oculto para el ID del medicamento -->
              <input type="hidden" name="medicamentoId[]" value="<?php echo htmlspecialchars($row['id']); ?>">
              <div class="input-group">
                  <label>Nombre del Medicamento:</label>
                  <input type="text" name="NombreMedicamento[]" value="<?php echo htmlspecialchars($row['NombreMedicamento']); ?>" required>
              </div>
              <div class="input-group">
                  <label>Principio Activo:</label>
                  <input type="text" name="NombreActivo[]" value="<?php echo htmlspecialchars($row['NombreActivo']); ?>" required>
              </div>
              <div class="input-group">
                  <label>Presentación (mg, UI):</label>
                  <input type="text" name="Presentacion[]" value="<?php echo htmlspecialchars($row['Presentacion']); ?>" required>
              </div>
              <div class="input-group">
                  <label>Dosis (mg):</label>
                  <input type="number" name="Dosis[]" min="0" max="300" value="<?php echo htmlspecialchars($row['Dosis']); ?>" required>
              </div>
              <div class="input-group">
                  <label>Vía:</label>
                  <input type="text" name="Via[]" value="<?php echo htmlspecialchars($row['Via']); ?>" required>
              </div>
              <div class="input-group">
                  <label>Última Administración (Fecha):</label>
                  <input type="date" name="FechaUlAdmin[]" value="<?php echo htmlspecialchars($row['FechaUlAdmin']); ?>" required>
              </div>
              <div class="input-group">
                  <label>Hora Última Administración:</label>
                  <input type="time" name="HoraUlAdmin[]" value="<?php echo htmlspecialchars($row['HoraUlAdmin']); ?>" required>
              </div>
          </div>
      <?php
          }
      } else {
          echo "<p>No se encontraron medicamentos consumidos.</p>";
      }
      $stmt->close();
      $conn->close();
      ?>
          <div class="actions">
              <button type="submit" name="action" value="actualizar" class="btn btn-update">Actualizar</button>
              <button type="button" onclick="window.location.href='/DocControl/controllers/ListaMeddicamentos.php'" class="btn btn-back">Regresar</button>
          </div>
      </form>
  </section>
</body>
</html>
