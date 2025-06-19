<?php
// Se verifica que el formulario se haya enviado mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Se obtienen los valores enviados desde el formulario usando el arreglo $_POST
    // Cada variable corresponde a un campo del formulario relacionado con antecedentes heredofamiliares
    $diabetes_opc = $_POST["DiabetesOpc"];
    $diabetes_familia = $_POST["DiabetesFamilia"];
    $cancer_opc = $_POST["CancerOpc"];
    $cancer_familia = $_POST["CancerFamilia"];
    $cancer_tipo = $_POST["CancerTipo"];
    $nefropatas_opc = $_POST["NefropatasOpc"];
    $nefropatas_familia = $_POST["NefropatasFamilia"];
    $cardiopatas_opc = $_POST["CardiopatasOpc"];
    $cardiopatas_familia = $_POST["CardiopatasFamilia"];
    $hipertension_opc = $_POST["HipertensionOpc"];
    $hipertension_familia = $_POST["HipertensionFamilia"];
    $malformaciones_opc = $_POST["MalformacionesOpc"];
    $malformaciones_familia = $_POST["MalformacionesFamilia"];
    $malformaciones_tipo = $_POST["MalformacionesTipo"];
    $otro_opc = $_POST["OtroOpc"];
    $otro_familia = $_POST["OtroFamilia"];
    $otro_tipo = $_POST["OtroTipo"];

    // Parámetros para la conexión a la base de datos
    $servername = "localhost";  // Servidor de base de datos (local)
    $username = "root";         // Usuario de la base de datos
    $password = "";             // Contraseña (vacía en este caso)
    $dbname = "clinica";        // Nombre de la base de datos a utilizar

    // Se establece la conexión a la base de datos utilizando la extensión mysqli en forma orientada a objetos
    $conn = new mysqli($servername, $username, $password, $dbname);
   
    // Se verifica si hubo error al conectar; de haberlo, se termina la ejecución mostrando un mensaje
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Se obtiene la CURP del último paciente registrado
    // Se realiza una consulta SQL que ordena los registros de la tabla 'paciente' de forma descendente según la CURP y limita el resultado a 1
    $sql = "SELECT curp FROM paciente ORDER BY curp DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Si se encontró algún registro, se extrae la CURP del paciente
        $row = $result->fetch_assoc();
        $paciente_curp = $row["curp"];
    } else {
        // Si no hay pacientes registrados, se muestra un mensaje y se detiene la ejecución
        echo "No se encontró ningún paciente registrado.";
        exit;
    }
    
    // Se construye la consulta SQL para insertar los datos de antecedentes heredofamiliares en la tabla 'Datos_heredofamiliares'
    // Se relaciona cada campo con su respectiva variable obtenida del formulario
    $sql = "INSERT INTO Datos_heredofamiliares(paciente_curp, diabetes_opc, diabetes_familia, cancer_opc, cancer_familia, cancer_tipo, nefropatas_opc, nefropatas_familia, cardiopatas_Opc, cardiopatas_familia, hipertension_opc, hipertension_familia, malformaciones_opc, malformaciones_familia, malformaciones_tipo, otro_opc, otro_familia, otro_tipo)
            VALUES ('$paciente_curp', '$diabetes_opc', '$diabetes_familia', '$cancer_opc', '$cancer_familia', '$cancer_tipo', '$nefropatas_opc', '$nefropatas_familia', '$cardiopatas_opc', '$cardiopatas_familia', '$hipertension_opc', '$hipertension_familia', '$malformaciones_opc', '$malformaciones_familia', '$malformaciones_tipo', '$otro_opc', '$otro_familia', '$otro_tipo')";

    // Se ejecuta la consulta de inserción y se verifica si fue exitosa
    if ($conn->query($sql) === TRUE) {
        // Si la inserción es exitosa, se redirige al usuario a la página "Formularios.html"
        header("Location: /DocControl/views/Formularios.html");
        exit;
    } else {
        // Si ocurre un error durante la inserción, se muestra un mensaje con el detalle del error
        echo "Error al registrar los datos heredofamiliares: " . $conn->error;
    }

    // Se cierra la conexión a la base de datos para liberar recursos
    $conn->close();
}
?>
