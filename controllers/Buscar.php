<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "clinica";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
session_start();
$curp = isset($_GET['curp']) ? $_GET['curp'] : '';
$_SESSION['curp'] = $curp;
$_SESSION['paciente_curp'] = $curp;

if (isset($_GET['curp'])) {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'actualizar') {
            $nombre             = $_POST['Nombre'];
            $apellidoPaterno    = $_POST['ApellidoPaterno'];
            $apellidoMaterno    = $_POST['ApellidoMaterno'];
            $edad               = $_POST['Edad'];
            $entidadNacimiento  = $_POST['Entidad'];
            $escolaridad        = $_POST['Escolaridad'];
            $derechoHabiencia   = $_POST['Derechohabiente'];
            $religion           = $_POST['Religion'];
            $estadoCivil        = $_POST['EstadoCivil'];
            $ocupacion          = $_POST['Ocupacion'];
            $fechaNacimiento    = $_POST['FechaNacimiento'];
            $genero             = $_POST['Genero'];

            $sql = "UPDATE paciente SET 
                        nombre='$nombre', 
                        apellidoPaterno='$apellidoPaterno', 
                        apellidoMaterno='$apellidoMaterno', 
                        edad='$edad', 
                        entidadNacimiento='$entidadNacimiento', 
                        escolaridad='$escolaridad', 
                        derechoHabiencia='$derechoHabiencia', 
                        religion='$religion', 
                        estadoCivil='$estadoCivil', 
                        ocupacion='$ocupacion', 
                        fechaNacimiento='$fechaNacimiento', 
                        genero='$genero' 
                    WHERE curp='$curp'";

            if (!mysqli_query($conn, $sql)) {
                echo "Error al actualizar los datos del paciente: " . mysqli_error($conn);
            }
        } elseif ($_POST['action'] === 'ver_consultas') {
            header("Location:/DocControl/controllers/Consultas.php");
            exit;
        } elseif ($_POST['action'] === 'ver_Informacion') {
            header("Location: /DocControl/views/FormulariosEditables.html");
            exit;
        } elseif ($_POST['action'] === 'crear_consulta') {
            header("Location: /DocControl/views/FichaClinica.html");
            exit;
        }
    }

    $sql = "SELECT * FROM paciente WHERE curp = '$curp'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nombre             = $row["nombre"];
        $apellidoPaterno    = $row["apellidoPaterno"];
        $apellidoMaterno    = $row["apellidoMaterno"];
        $edad               = $row["edad"];
        $entidadNacimiento  = $row["entidadNacimiento"];
        $escolaridad        = $row["escolaridad"];
        $derechoHabiencia   = $row["derechoHabiencia"];
        $religion           = $row["religion"];
        $estadoCivil        = $row["estadoCivil"];
        $ocupacion          = $row["ocupacion"];
        $fechaNacimiento    = $row["fechaNacimiento"];
        $genero             = $row["genero"];
    } else {
        header("Location: error.php");
        exit();
    }
} else {
    header("Location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Paciente encontrado</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap">
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
      background: #fff;
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
    .container header, .container h1 {
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
    .form-row {
      display: flex;
      gap: 24px;
      flex-wrap: wrap;
    }
    .column {
      flex: 1 1 0;
      min-width: 180px;
      display: flex;
      flex-direction: column;
      gap: 18px;
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
    .invalid {
      border: 2px solid #e63946 !important;
    }
    .form .button-row {
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
      margin-top: 10px;
      justify-content: center;
    }
    .button,
    .form button {
      background: linear-gradient(to right, #1a2537, #3b82f6);
      color: #fff;
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
      .container header, .container h1 { font-size: 1.5rem; }
      .form-row { flex-direction: column; gap: 0; }
    }
    </style>
</head>
<body>
    <section class="container">
        <h1>Paciente encontrado</h1>
        <form method="POST" class="form" id="formulario">
            <div class="form-row">
                <div class="column">
                    <div class="input-box">
                        <label>Nombre(s)</label>
                        <input type="text" id="nombre" name="Nombre" value="<?php echo htmlspecialchars($nombre); ?>" />
                    </div>
                    <div class="input-box">
                        <label>Apellido Paterno</label>
                        <input type="text" id="apellidoPaterno" name="ApellidoPaterno" value="<?php echo htmlspecialchars($apellidoPaterno); ?>" />
                    </div>
                    <div class="input-box">
                        <label>Apellido Materno</label>
                        <input type="text" id="apellidoMaterno" name="ApellidoMaterno" value="<?php echo htmlspecialchars($apellidoMaterno); ?>" />
                    </div>
                </div>
                <div class="column">
                    <div class="input-box">
                        <label>Edad</label>
                        <input type="number" id="edad" name="Edad" value="<?php echo htmlspecialchars($edad); ?>" />
                    </div>
                    <div class="input-box">
                        <label>Derechohabiente</label>
                        <input type="text" name="Derechohabiente" value="<?php echo htmlspecialchars($derechoHabiencia); ?>" />
                    </div>
                    <div class="input-box">
                        <label>Fecha de Nacimiento</label>
                        <input type="date" name="FechaNacimiento" id="fechaNacimiento" value="<?php echo htmlspecialchars($fechaNacimiento); ?>" />
                    </div>
                </div>
                <div class="column">
                    <div class="input-box">
                        <label>Entidad de Nacimiento</label>
                        <input type="text" name="Entidad" value="<?php echo htmlspecialchars($entidadNacimiento); ?>" />
                    </div>
                    <div class="input-box">
                        <label>Genero</label>
                        <input type="text" name="Genero" value="<?php echo htmlspecialchars($genero); ?>" />
                    </div>
                    <div class="input-box">
                        <label>Escolaridad</label>
                        <input type="text" name="Escolaridad" value="<?php echo htmlspecialchars($escolaridad); ?>" />
                    </div>
                </div>
            </div>
            <div class="input-box">
                <label>CURP</label>
                <input type="text" id="curp" name="Curp" value="<?php echo htmlspecialchars($curp); ?>" readonly />
            </div>
            <div class="form-row button-row">
                <button type="submit" name="action" value="ver_Informacion">Ver Información</button>
                <button type="submit" name="action" value="actualizar">Actualizar</button>
                <button type="submit" name="action" value="ver_consultas">Ver Consultas</button>
                <button type="submit" name="action" value="crear_consulta">Crear consulta</button>
            </div>
            <div class="form-row button-row">
                <button type="button" onclick="window.location.href = '/DocControl/public/index.html'">Menú Principal</button>
            </div>
        </form>
    </section>
</body>
</html>
