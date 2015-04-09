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
		<p>Contrase&ntilde;a: <input type="password" name="user" /></p>
		<p>Aficiones:</p>
		<p><input type="checkbox" name="futbol" value="futbol" />Fútbol</p>
		<p><input type="checkbox" name="baloncesto" value="baloncesto" />Baloncesto</p>
		<p><input type="checkbox" name="balonmano" value="balonmano" />Balonmano</p>
		<p>Sexo:</p>
		<p><input type="radio" name="sexo" value="hombre" required="required" checked="checked" />Hombre</p>
		<p><input type="radio" name="sexo" value="mujer" required="required" />Mujer</p>
		<p>Provincia:
			<select name="Provincia">
				<option value="14">Córdoba</option>
				<option value="41">Sevilla</option>
			</select>
		</p>
		<textarea>Comentarios...</textarea>
		<p></p><input type="submit" value="Enviar" /></p>
	</form>
</body>
</html>