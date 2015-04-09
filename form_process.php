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

<?php
/* Procesar variables de entrada del formulario */
$user = (isset($_POST['user'])) ? $_POST['user'] : "";
$pass = (isset($_POST['pass'])) ? $_POST['pass'] : "";
$futbol = (isset($_POST['futbol'])) ? "Futbol" : "";
$baloncesto = (isset($_POST['baloncesto'])) ? "Baloncesto" : "";
$balonmano = (isset($_POST['balonmano'])) ? "Balonmano" : "";
$sexo = (isset($_POST['sexo'])) ? $_POST['sexo'] : "";
$provincia = (isset($_POST['provincia'])) ? $_POST['provincia'] : "";
$comentarios = (isset($_POST['comentarios'])) ? $_POST['comentarios'] : "";
?>

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

</body>
</html>