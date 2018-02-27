<?php
/* Procesar las variables de entrada del formulario */
$post_user = (isset($_POST['user'])) ? trim(strip_tags($_POST['user'])) : '';
$post_pass = (isset($_POST['pass'])) ? trim(strip_tags($_POST['pass'])) : '';
$post_futbol = (isset($_POST['futbol'])) ? "Futbol" : '';
$post_baloncesto = (isset($_POST['baloncesto'])) ? "Baloncesto" : '';
$post_balonmano = (isset($_POST['balonmano'])) ? "Balonmano" : '';
$post_sexo = (isset($_POST['sexo'])) ? trim(strip_tags($_POST['sexo'])) : '';
$post_provincia = (isset($_POST['provincia'])) ? trim(strip_tags($_POST['provincia'])) : '';
$post_comentarios = (isset($_POST['comentarios'])) ? htmlentities(trim($_POST["comentarios"]), ENT_HTML5, 'UTF-8') : '';
?>
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

<!-- Abrir "container" -->
<div class="container">

<!-- Abrir "card" -->
<div class="card">

<div class="card-header">
<?php
// Cargar el fichero que contiene la cabecera de la página
require_once('header.php');
?>
</div>

<div class="card-body">
<?php
/* Mostrar los datos del formulario en una tabla antes de insertarlos */
?>
<table class="table table-striped">
   <thead class="thead-dark">
      <tr>
         <th>Campo</th><th>Valor</th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td>Usuario</td><td><?php echo $post_user; ?></td>
      </tr>
      <tr>
         <td>Contraseña</td><td><?php echo $post_pass; ?></td>
      </tr>
      <tr>
         <td>Aficiones</td><td><?php echo $post_futbol . " " . $post_baloncesto . " " . $post_balonmano; ?></td>
      </tr>
      <tr>
         <td>Sexo</td><td><?php echo $post_sexo; ?></td>
      </tr>
      <tr>
         <td>Provincia</td><td><?php echo $post_provincia; ?></td>
      </tr>
      <tr>
         <td>Comentarios</td><td><?php echo html_entity_decode($post_comentarios); ?></td>
      </tr>
   </tbody>
</table>


<?php
/* Almacenar datos del formulario en la base de datos */

// Cargar las variables de conexión a la base de datos
require_once('connection.php');

try {
   // Iniciar la conexión a la base de datos
   $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);

   // Asginar el modo de error Silencio para chequear nosotros mismos los errores
   $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );

   // Asignar la codificación de caracteres a UTF-8
   $pdo->exec("SET NAMES 'utf8'");

   // Insertar los datos con parámetros preparados
   // bindParam para asignar valores en el momento de la ejecución
   $db_sentence = $pdo->prepare('INSERT INTO '.$db_table.' (user, pass, futbol, baloncesto, balonmano, sexo, provincia, comentarios)
                                 VALUES ( :user, :pass, :futbol, :baloncesto, :balonmano, :sexo, :provincia, :comentarios)');
   $db_sentence->bindParam(':user', $post_user, PDO::PARAM_STR);
   $db_sentence->bindParam(':pass', $post_pass, PDO::PARAM_STR);
   $db_sentence->bindParam(':futbol', $post_futbol, PDO::PARAM_STR);
   $db_sentence->bindParam(':baloncesto', $post_baloncesto, PDO::PARAM_STR);
   $db_sentence->bindParam(':balonmano', $post_balonmano, PDO::PARAM_STR);
   $db_sentence->bindParam(':sexo', $post_sexo, PDO::PARAM_STR);
   $db_sentence->bindParam(':provincia', $post_provincia, PDO::PARAM_INT);
   $db_sentence->bindParam(':comentarios', $post_comentarios, PDO::PARAM_STR);
   $db_sentence->execute();

   // Comprobar el resultado de la ejecución
   if ( $db_sentence->errorCode() == 0 ) {
      echo '<div class="alert alert-success" role="alert">Datos insertados correctamente</div>';
   } else {
      $db_error = $db_sentence->errorInfo();
      echo '<div class="alert alert-danger" role="alert">Error al insertar los datos: ' . $db_error[2] . '</div>';
   }

   // Cerrar la conexión a la base de datos
   $pdo = null;
}
catch(PDOException $e) {
   // Mostrar el error
   echo '<div class="alert alert-danger" role="alert">Error en la base de datos:'. $e->getMessage() . '</div>';
   // Parar la ejecución completa de la página
   // exit();
}
?>
</div>

<!-- Cerrar "card" -->
</div>

<a class="btn btn-primary" href="form.php" role="button">Volver al formulario</a>
<a class="btn btn-primary" href="index.php" role="button">Volver al &iacute;ndice</a>

<!-- Cerrar "container" -->
</div>
</body>
</html>
