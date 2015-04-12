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

<?php /* Procesar variables de entrada del formulario */
$user = (isset($_POST['user'])) ? $_POST['user'] : "";
$pass = (isset($_POST['pass'])) ? $_POST['pass'] : "";
$futbol = (isset($_POST['futbol'])) ? "Futbol" : "";
$baloncesto = (isset($_POST['baloncesto'])) ? "Baloncesto" : "";
$balonmano = (isset($_POST['balonmano'])) ? "Balonmano" : "";
$sexo = (isset($_POST['sexo'])) ? $_POST['sexo'] : "";
$provincia = (isset($_POST['provincia'])) ? $_POST['provincia'] : "";
$comentarios = (isset($_POST['comentarios'])) ? $_POST['comentarios'] : "";
?>

<?php /* Mostrar datos en HTML */ ?>
<table border="1">
    <tr>
        <td>Usuario</td><td><?php echo $user; ?></td>
    </tr>
    <tr>
        <td>Contraseña</td><td><?php echo $pass; ?></td>
    </tr>
    <tr>
        <td>Aficiones</td><td><?php echo $futbol . " " . $baloncesto . " " . $balonmano; ?></td>
    </tr>
    <tr>
        <td>Sexo</td><td><?php echo $sexo; ?></td>
    </tr>
    <tr>
        <td>Provincia</td><td><?php echo $provincia; ?></td>
    </tr>
    <tr>
        <td>Comentarios</td><td><?php echo $comentarios; ?></td>
    </tr>
</table>

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

    // Insertar datos con parámetros preparados y bindParam para asignar valores en el momento de la ejecución
    $db_sentence = $pdo->prepare('INSERT INTO '.$db_table.' (user, pass, futbol, baloncesto, balonmano, sexo, provincia, comentarios)
                                  VALUES ( :user, :pass, :futbol, :baloncesto, :balonmano, :sexo, :provincia, :comentarios)');
    $db_sentence->bindParam(':user', $user);
    $db_sentence->bindParam(':pass', $pass);
    $db_sentence->bindParam(':futbol', $futbol);
    $db_sentence->bindParam(':baloncesto', $baloncesto);
    $db_sentence->bindParam(':balonmano', $balonmano);
    $db_sentence->bindParam(':sexo', $sexo);
    $db_sentence->bindParam(':provincia', $provincia);
    $db_sentence->bindParam(':comentarios', $comentarios);
    $db_sentence->execute();

	// Comprobar el resultado de la ejecución
	if ( $db_sentence->errorCode() == 0 ) {
		echo '<p>Datos insertados correctamente</p>'; 
	} else {
		$db_error = $db_sentence->errorInfo();
		echo '<p>Error al insertar los datos: ' . $db_error[2] . '</p>';
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

</body>
</html>