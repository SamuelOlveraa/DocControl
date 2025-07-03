<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Medicamentos en uso</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Aquí se insertan todos los estilos modernos que compartiste */
        /* -------- FUENTES Y RESET -------- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

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
            max-width: 900px;
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
        }

        .medicamento {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: all 0.3s ease-in-out;
        }

        .medicamento p {
            margin-bottom: 8px;
            font-size: 0.95rem;
            color: #1f2937;
        }

        .button {
            background: linear-gradient(to right, #1a2537, #3b82f6);
            color: #ffffff;
            padding: 12px 18px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            margin: 10px;
            display: inline-block;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 6px 12px rgba(59, 130, 246, 0.25);
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.4);
            background: linear-gradient(to right, #3b82f6, #1a2537);
        }

        .acciones {
            text-align: center;
            margin-top: 30px;
        }

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
        <header>Medicamentos en uso</header>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "clinica";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("<p>Error de conexión: " . mysqli_connect_error() . "</p>");
        }

        session_start();
        $curp = isset($_SESSION['curp']) ? $_SESSION['curp'] : '';

        if (!empty($curp)) {
            $sql = "SELECT * FROM medicamentos WHERE paciente_curp = '$curp'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $medicamentoId = $row['id'];
                    echo "<div class='medicamento'>";
                    echo "<p><strong>Nombre:</strong> {$row['NombreMedicamento']}</p>";
                    echo "<p><strong>Principio activo:</strong> {$row['NombreActivo']}</p>";
                    echo "<p><strong>Presentación:</strong> {$row['Presentacion']}</p>";
                    echo "<p><strong>Dosis:</strong> {$row['Dosis']}</p>";
                    echo "<p><strong>Vía:</strong> {$row['Via']}</p>";
                    echo "<p><strong>Última administración:</strong> {$row['FechaUlAdmin']} {$row['HoraUlAdmin']}</p>";
                    echo "</div>";
                }

                echo "<div class='acciones'>";
                echo "<a class='button' href='/DocControl/controllers/MoMedicamentos.php?id=$medicamentoId'>Editar</a>";
                echo "<a class='button' href='/DocControl/views/FormulariosEditables.html?id=$medicamentoId'>Regresar</a>";
                echo "</div>";
            } else {
                echo "<p style='text-align:center;'>No se encontraron medicamentos para este paciente.</p>";
            }
        } else {
            echo "<p style='text-align:center;'>No se encontró el CURP en la sesión.</p>";
        }

        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
