<?php
/* Procesar las variables de entrada */
$get_file = (isset($_GET['file'])) ? trim(strip_tags($_GET['file'])) : '';

// Cargar las variables de conexión a la base de datos
require_once('connection.php');

try {
   // Iniciar la conexión a la base de datos
   $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);

   // Asginar el modo de error Silencio para chequear nosotros mismos los errores
   $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );   

   // Asignar la codificación de caracteres a UTF-8
   $pdo->exec("SET NAMES 'utf8'");

   // Recuperar datos con parámetros preparados 
   // bindParam para asignar valores en el momento de la ejecución
   $db_sentence = $pdo->prepare('SELECT * FROM '.$db_table);
   $db_sentence->execute();

   // Comprobar el resultado de la ejecución
   if ( $db_sentence->errorCode() != 0 ) {
      // Error en la sentencia
      $db_error = $db_sentence->errorInfo();
      $json_data[] = array(
         'error' => $db_error[2],
         );
      } elseif ( $db_sentence->rowCount() == 0) {
      // Ningún dato recuperado
      $json_data[] = array(
         'Mensaje' => 'No hay datos',
         );
      } else {
      // Leer datos recuperados
      while ( $row = $db_sentence->fetch() ) {
         $json_data[] = array(
            'id' => $row['id'],
            'user' => $row['user'],
            'pass' => $row['pass'],
            'aficiones' => array(
               'Fúbol' => ($row['futbol'] != '') ? true : false,
               'Baloncesto' => ($row['baloncesto'] != '') ? true : false,
               'Balonmano' => ($row['balonmano'] != '') ? true : false,
               ),
            'sexo' => $row['sexo'],
            'provincia' => $row['provincia'],
            'comentarios' => html_entity_decode($row['comentarios'], ENT_HTML5, 'UTF-8'),
            );
      }
   }
    
   // Cerrar la conexión a la base de datos
   $pdo = null;
}
catch(PDOException $e) {
   // Mostrar el error
   $json_data[] = array(
      'error' => $e->getMessage(),
      );
   // Parar la ejecución completa de la página si lo necesitáramos
   // exit();
}

// Enviar el documento al navegador
if ( $get_file == 'download' ) {
   // Esta cabecera sólo es necesaria si se desea descargar como archivo
   header('Content-disposition: attachment; filename=datos.json');
}
header('Content-type: application/json;charset=utf-8');
echo json_encode($json_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
