<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="utf-8">
   <title>DemoPHP</title>
   <meta name="description" content="Demo PHP">
   <meta name="author" content="Rafa Morales">
   <meta name="viewport" content="width=device-width; initial-scale=1.0">
</head>
<body>

<?php
// Cargar el fichero que contiene la cabecera de la página
require_once('header.php'); 
?>

<nav>
   <h2>Men&uacute;</h2>
   <ul>
      <li><a href="form.php">Insertar datos</a></li>
      <li><a href="select_data.php">Ver datos</a></li>
      <li><a href="xml_data.php">Exportar datos a XML</a></li>
   </ul>
</nav>
</body>
</html>