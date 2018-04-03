<!DOCTYPE html>
<html lang="es">
<head>
   <!-- Meta tags -->
   <meta charset="utf-8">
   <meta name="description" content="Demo PHP">
   <meta name="author" content="Rafa Morales">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

   <!-- Title -->
   <title>DemoPHP</title>
</head>
<body>
   <div class="container">
      <div class="card">
         <div class="card-header">
            <?php
            // Cargar el fichero que contiene la cabecera de la página
            require_once('header.php');
            ?>
         </div>
         <div class="card-body">
            <nav>
               <h2>Men&uacute;</h2>
               <ul class="nav flex-column">
                  <li class="nav-item"><a class="nav-link" href="insert_form.php">Insertar datos</a></li>
                  <li class="nav-item"><a class="nav-link" href="select_data.php">Ver datos</a></li>
                  <li class="nav-item"><a class="nav-link" href="xml_data.php">Ver datos XML</a></li>
                  <li class="nav-item"><a class="nav-link" href="xml_data.php?file=download">Descargar datos XML</a></li>
                  <li class="nav-item"><a class="nav-link" href="json_data.php">Ver datos JSON</a></li>
                  <li class="nav-item"><a class="nav-link" href="json_data.php?file=download">Descargar datos JSON</a></li>
               </ul>
            </nav>
         </div>
      </div>
   </div>
</body>
</html>
