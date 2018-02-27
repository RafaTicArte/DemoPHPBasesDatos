<?php
/* Procesar las variables de entrada del formulario */
$get_delete_id = (isset($_GET['delete_id'])) ? trim(strip_tags($_GET['delete_id'])) : '';
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
/* Eliminar datos de la base de datos en función del parámetro pasado por el método GET */

if ( $get_delete_id == '' ) {
   // No se ha pasado el ID a eliminar
   echo '<div class="alert alert-danger" role="alert">No se ha especificado los datos a eliminar</div>';
} else {
   // Cargar las variables de conexión a la base de datos
   require_once('connection.php');

   try {
      // Iniciar la conexión a la base de datos
      $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);

      // Asginar el modo de error Silencio para chequear nosotros mismos los errores
      $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );

      // Insertar los datos con parámetros preparados
      // bindParam para asignar valores en el momento de la ejecución
      $db_sentence = $pdo->prepare('DELETE FROM '.$db_table.'
                                    WHERE id=:id');
      $db_sentence->bindParam(':id', $get_delete_id);
      $db_sentence->execute();

      // Comprobar el resultado de la ejecución
      if ( $db_sentence->errorCode() == 0 and $db_sentence->rowCount() >= 1 ) {
         // No hay errores y se han eliminado una fila o más
         echo '<div class="alert alert-success" role="alert">Datos eliminados correctamente</div>';
      } else if ( $db_sentence->errorCode() == 0 and $db_sentence->rowCount() == 0 ) {
         // No hay errores pero no se han eliminado filas
         echo '<div class="alert alert-danger" role="alert">Ese dato no existe en la base de datos</div>';
      } else {
         // Erores en la sentencia
         $db_error = $db_sentence->errorInfo();
         echo '<div class="alert alert-danger" role="alert">Error al eliminar los datos: ' . $db_error[2] . '</div>';
      }

      // Cerrar la conexión a la base de datos
      $pdo = null;
   }
   catch(PDOException $e) {
      // Mostrar el error
      echo '<div class="alert alert-danger" role="alert">Error en la base de datos: ' . $e->getMessage() . '</div>';
      // Parar la ejecución completa de la página
      // exit();
   }
}
?>

</div>

<!-- Cerrar "card" -->
</div>

<a class="btn btn-primary" href="select_data.php" role="button">Volver al listado</a>
<a class="btn btn-primary" href="index.php" role="button">Volver al &iacute;ndice</a>

<!-- Cerrar "container" -->
</div>

</body>
</html>
