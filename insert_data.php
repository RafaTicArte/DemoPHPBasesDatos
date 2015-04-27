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

<?php 
/* Mostrar los datos del formulario en una tabla */ 
?>
<table border="1">
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
      echo '<p>Datos insertados correctamente</p>'; 
   } else {
      $db_error = $db_sentence->errorInfo();
      echo '<p>Error al insertar los datos: ' . $db_error[2] . '</p>';
   }

   // Cerrar la conexión a la base de datos
   $pdo = null;
}
catch(PDOException $e) {
   // Mostrar el error
   echo '<p>Error en la base de datos:</p>';
   echo '<p>' . $e->getMessage() . '</p>';
   // Parar la ejecución completa de la página
   // exit();
}
?>

</body>
</html>
