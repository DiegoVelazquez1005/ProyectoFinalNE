<?php
// Conexión a la base de datos MySQL
$servername = "localhost";
$username = "root";
$password = "Mi4353fe";
$dbname = "newdbname";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST["nombre"];
$correo = $_POST["correo"];
$nivel = $_POST["nivel"];
$opciones = isset($_POST["opcion"]) ? $_POST["opcion"] : array();
$pago = $_POST["pago"];

//Serializa los valores seleccionados en una cadena JSON
$opciones_serializadas = json_encode($opciones);

// Preparar la consulta
$sql = "INSERT INTO eq5_client (nombre, correo, nivel, opciones, pago) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nombre, $correo, $nivel, $opciones_serializadas, $pago);

// Ejecutar la consulta preparada
if ($stmt->execute()) {
    // Mensaje de agradecimiento
    echo "Gracias por enviar el formulario. Nos pondremos en contacto contigo pronto. <br> <a href='index.html'>Regresar</a></center>";

    // Consulta para obtener el estado actual de la tabla
    $selectSql = "SELECT * FROM eq5_client";
    $result = $conn->query($selectSql);

    // Crear contenido del archivo
    $content = "";

    // Mostrar el estado actual de la tabla
    if ($result->num_rows > 0) {
        $content .= "Estado actual de la tabla eq5_client:\n\n";
        $content .= "--------------------------------------------------------------------------------------------------------------------------------------\n";
        $content .= "| Nombre        	    | Nivel    		   | Pago    		  | Correo                    | Opciones             |\n";
        $content .= "--------------------------------------------------------------------------------------------------------------------------------------\n";
        while ($row = $result->fetch_assoc()) {
            $content .= "| " . str_pad($row["nombre"], 25, " ") . " | " . str_pad($row["nivel"], 20, " ") . " | " . str_pad($row["pago"], 20, " ") . " | " . str_pad($row["correo"], 25, " ") . " | " . str_pad($row["opciones"], 20, " ") . " |\n";
        }
        $content .= "--------------------------------------------------------------------------------------------------------------------------------------\n\n";
    } else {
        $content .= "La tabla eq5_client está vacía.\n\n";
    }

    // Enunciado personalizado para cada registro
    $content .= "Reportes:\n\n";
    //$content .= "Nombre\tCorreo\tNivel\tOpciones\tPago\n";
    $result->data_seek(0); // Reiniciar el puntero del resultado
    while ($row = $result->fetch_assoc()) {
        //$content .= $row["nombre"] . "\t" . $row["correo"] . "\t" . $row["nivel"] . "\t" . $row["opciones"] . "\t" . $row["pago"] . "\n";
        $content .= "El usuario llamado " . $row["nombre"] . " y correo " . $row["correo"] . " desea inscribirse al nivel " . $row["nivel"] . " con una forma de pago " . $row["pago"] . " y desea recibir en su correo: " . $row["opciones"] . ".\n\n";
    }

    // Guardar contenido en un archivo de texto
    $filename = "estado_clientes.txt";
    file_put_contents($filename, $content);

    // Descargar el archivo
    echo "<br> <a href='$filename' download> Descargar Reporte</a>";

    exit;
} else {
    echo "Error al ingresar los datos: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
