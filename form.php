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
	<form action="form_process.php" method="post">
		<p>Usuario: <input type="text" name="user" /></p>
		<p>Contrase&ntilde;a: <input type="password" name="pass" /></p>
		<p>Aficiones:</p>
		<p><input type="checkbox" name="futbol" />Fútbol</p>
		<p><input type="checkbox" name="baloncesto" />Baloncesto</p>
		<p><input type="checkbox" name="balonmano" />Balonmano</p>
		<p>Sexo:</p>
		<p><input type="radio" name="sexo" value="H" required="required" checked="checked" />Hombre</p>
		<p><input type="radio" name="sexo" value="M" required="required" />Mujer</p>
		<p>Provincia:
			<select name="provincia">
				<option value="14">Córdoba</option>
				<option value="41">Sevilla</option>
			</select>
		</p>
		<textarea cols="45" rows="5" name="comentarios">Comentarios...</textarea>
		<p></p><input type="submit" value="Enviar" /></p>
	</form>
</body>
</html>