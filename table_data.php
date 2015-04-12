<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>DemoPHP</title>
    <meta name="description" content="Demo PHP">
    <meta name="author" content="Rafa Morales">
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
</head>
<body>
    <header>
        <h1>Demo PHP</h1>
    </header>
    
    <table border="1">
        <tr>
            <th>Id</th>
            <th>Usuario</th>
            <th>Contrase&ntilde;a</th>
            <th>Futbol</th>
            <th>Baloncesto</th>
            <th>Balonmano</th>
            <th>Sexo</th>
            <th>Provincia</th>
            <th>Comentarios</th>
        </tr>
<?php /* Almacenar datos en Base de Datos */ 
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'demophp';
$db_table = 'usuarios';
$db_sentence = '';
$db_error = '';

try {
    // Iniciar conexión a la base de datos
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);

    // Modo de error en silencio para chequear nosotros mismos los errores
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );   

    // Recuperar datos de la base de datos
    $db_sentence = $pdo->query('SELECT * FROM '.$db_table);

    // Comprobar el resultado de la ejecución
    if ( $db_sentence == false ) {
        // Error en la sentencia
        echo '<p>Error al recuperar los datos</p>';
    } elseif ( $db_sentence->fetchColumn() == 0) {
        // Ningún dato recuperado
        echo '<tr><td colspan="9">No hay datos.</td></tr>';
    } else {
        // Leer datos recuperados
        while ($row = $db_sentence->fetch()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . "</td>";
            echo '<td>' . $row['user'] . "</td>";
            echo '<td>' . $row['pass'] . "</td>";
            echo '<td>' . $row['futbol'] . "</td>";
            echo '<td>' . $row['baloncesto'] . "</td>";
            echo '<td>' . $row['balonmano'] . "</td>";
            echo '<td>' . $row['sexo'] . "</td>";
            echo '<td>' . $row['provincia'] . "</td>";
            echo '<td>' . $row['comentarios'] . "</td>";
            echo '</tr>';
        }
    }
    
    // Cerrar conexión a la base de datos
    $pdo = null;
}
catch(PDOException $e) {
    // Mostrar el error
    echo '<p>Error en la base de datos:</p>';
    echo '<p>' . $e->getMessage() . '</p>';
    // Con exit() paramos la ejecución completa de la página si lo necesitáramos
    // exit();
}
?>
    </table>
    
</body>
</html>