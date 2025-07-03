<!DOCTYPE html>
<html>
<head>
    <title>Visitas del Paciente</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
    /* -----------------------------------------------------------
       FUENTES Y RESET
    ----------------------------------------------------------- */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    /* -----------------------------------------------------------
       FONDO ANIMADO MODERNO
    ----------------------------------------------------------- */
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

    /* -----------------------------------------------------------
       CONTENEDOR CENTRAL
    ----------------------------------------------------------- */
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

    /* -----------------------------------------------------------
       ENCABEZADO DE SECCIÓN
    ----------------------------------------------------------- */
    .container header {
      font-size: 2rem;
      font-weight: 700;
      color: #1a2537;
      text-align: center;
      margin-bottom: 30px;
      letter-spacing: 0.5px;
    }

    /* -----------------------------------------------------------
       BOTÓN MODERNO
    ----------------------------------------------------------- */
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
      text-decoration: none;
      display: inline-block;
      margin-bottom: 8px;
    }

    .button:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(59, 130, 246, 0.4);
      background: linear-gradient(to right, #3b82f6, #1a2537);
    }

    /* -----------------------------------------------------------
       ENLACES
    ----------------------------------------------------------- */
    .link {
      text-decoration: none;
      color: #1a2537;
      font-weight: 600;
    }

    .link:hover {
      color: #3b82f6;
      text-decoration: underline;
    }

    /* -----------------------------------------------------------
       BOTONES CONTAINER
    ----------------------------------------------------------- */
    .button-container {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
      justify-content: center;
      margin-bottom: 20px;
    }

    /* -----------------------------------------------------------
       RESPONSIVE
    ----------------------------------------------------------- */
    @media (max-width: 600px) {
      .container {
        padding: 25px;
      }
      .container header {
        font-size: 1.5rem;
      }
    }
    </style>
</head>
<body>
    <div class="container">
        <header>Visitas del Paciente</header>
        <div class="button-container">
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
            $curp = isset($_SESSION['curp']) ? $_SESSION['curp'] : '';
            if (!empty($curp)) {
                $sql = "SELECT DISTINCT fecha FROM FichaClinica WHERE paciente_curp = '$curp' ORDER BY fecha DESC";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $fechaVisita = htmlspecialchars($row['fecha']);
                        echo "<a class='button' href='/DocControl/controllers/Visitas.php?fecha=$fechaVisita'>$fechaVisita</a>";
                    }
                } else {
                    echo "<span style='color:#1a2537;font-weight:600;'>No se encontraron visitas para este paciente.</span>";
                }
            } else {
                echo "<span style='color:#e63946;font-weight:600;'>No se encontró el CURP en la sesión.</span>";
            }
            mysqli_close($conn);
            ?>
        </div>
    </div>
</body>
</html>
