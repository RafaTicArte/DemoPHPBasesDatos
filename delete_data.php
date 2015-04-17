<?php 
/* Procesar las variables de entrada del formulario */
$get_delete_id = (isset($_GET['delete_id'])) ? trim(strip_tags($_GET['delete_id'])) : '';
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
/* Eliminar datos de la base de datos en función del parámetro pasado por el método GET */ 

if ( $get_delete_id == '' ) {
   // No se ha pasado el ID a eliminar
   echo '<p>No se ha especificado los datos a eliminar</p>';
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
         echo '<p>Datos eliminados correctamente</p>';
      } else if ( $db_sentence->errorCode() == 0 and $db_sentence->rowCount() == 0 ) {
         // No hay errores pero no se han eliminado filas
         echo '<p>Ese dato no existe en la base de datos</p>';
      } else {
         // Erores en la sentencia
         $db_error = $db_sentence->errorInfo();
         echo '<p>Error al eliminar los datos: ' . $db_error[2] . '</p>';
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
}
?>

</body>
</html>