<!DOCTYPE html>
<html>
<head>
    <style>
        /* Estilos adicionales */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            background: url(fondo.jpg);
            background-size: cover;
            background-attachment: fixed;
        }

        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            margin-top: 50px;
        }

        .medicamento {
            background-color: #ffffff;
            padding: 20px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #ffffff;
            font-size: 40px;
            margin-top: 50px;
        }

        .button {
            display: inline-block;
            background-color: #1a2537;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #0c1522;
        }

        p {
            margin-bottom: 10px;
        }

        /* Nuevo estilo para centrar los botones y ubicarlos al final */
        .container {
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<h1 style="text-align: center;">Medicamentos en uso</h1>
<div class="button-container">
    <?php
    // Establecer la conexión con la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "clinica";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    session_start(); // Iniciar la sesión

    // Obtener el valor de la CURP de la sesión
    $curp = isset($_SESSION['curp']) ? $_SESSION['curp'] : '';

    // Consultar los medicamentos del paciente
    if (!empty($curp)) {
        $sql = "SELECT * FROM medicamentos WHERE paciente_curp = '$curp'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            // Mostrar la lista de medicamentos
            echo "<div class='medicamentos-container'>";
            while ($row = mysqli_fetch_assoc($result)) {
                $medicamentoId = $row['id'];
                $nombreMedicamento = $row['NombreMedicamento'];
                $nombreActivo = $row['NombreActivo'];
                $presentacion = $row['Presentacion'];
                $dosis = $row['Dosis'];
                $via = $row['Via'];
                $fechaUlAdmin = $row['FechaUlAdmin'];
                $horaUlAdmin = $row['HoraUlAdmin'];

                // Mostrar información del medicamento
                echo "<div class='medicamento'>";
                echo "<p><strong>Nombre:</strong> $nombreMedicamento</p>";
                echo "<p><strong>Principio activo:</strong> $nombreActivo</p>";
                echo "<p><strong>Presentación:</strong> $presentacion</p>";
                echo "<p><strong>Dosis:</strong> $dosis</p>";
                echo "<p><strong>Vía:</strong> $via</p>";
                echo "<p><strong>Última administración:</strong> $fechaUlAdmin $horaUlAdmin</p>";
                echo "</div>";
            }
            echo "</div>";

            // Sección de botones (Editar y Regresar) centrada y al final del último contenedor
            echo "<div class='container'>";
                echo "<a class='button' href='/DocControl/controllers/MoMedicamentos.php?id=$medicamentoId'>Editar</a>";
                echo "<a class='button' href='/DocControl/views/FormulariosEditables.html?id=$medicamentoId'>Regresar</a>";
            echo "</div>";

        } else {
            echo "<p>No se encontraron medicamentos para este paciente.</p>";
        }
    } else {
        echo "<p>No se encontró el CURP en la sesión.</p>";
    }

    mysqli_close($conn);
    ?>
</div>
</body>
</html>
