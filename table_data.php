<?php 
/* Procesar las variables de entrada */
$get_user = (isset($_GET['user'])) ? trim(strip_tags($_GET['user'])) : "";
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

<table border="1">
   <tr>
      <th>Id</th>
      <th>Usuario <a href="table_data.php?user=asc">ASC</a> <a href="table_data.php?user=des">DES</a></th>
      <th>Contrase&ntilde;a</th>
      <th>Futbol</th>
      <th>Baloncesto</th>
      <th>Balonmano</th>
      <th>Sexo</th>
      <th>Provincia</th>
      <th>Comentarios</th>
   </tr>

<?php 
/* Mostrar los datos de la base de datos en una tabla */ 

// Cargar las variables de conexión a la base de datos
require_once('connection.php');

try {
   // Iniciar la conexión a la base de datos
   $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);

   // Asginar el modo de error Silencio para chequear nosotros mismos los errores
   $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );   

   // Preparar la ordenación de los datos
   $db_order = '';
   if ($get_user == 'asc') $db_order = 'ORDER BY user ASC';
   if ($get_user == 'des') $db_order = 'ORDER BY user DESC';

   // Recuperar datos con parámetros preparados 
   // bindParam para asignar valores en el momento de la ejecución
   $db_sentence = $pdo->prepare('SELECT * FROM '.$db_table.' '.$db_order);
   $db_sentence->execute();

   // Comprobar el resultado de la ejecución
   if ( $db_sentence->errorCode() != 0 ) {
      // Error en la sentencia
      $db_error = $db_sentence->errorInfo();
      echo '<tr><td colspan="9">Error al recuperar los datos: '. $db_error[2] .'</td></tr>';
   } elseif ( $db_sentence->rowCount() == 0) {
      // Ningún dato recuperado
      echo '<tr><td colspan="9">No hay datos.</td></tr>';
   } else {
      // Leer datos recuperados
      while ($row = $db_sentence->fetch()) {
         echo '<tr>';
         echo '<td>' . $row['id'] . "</td>";
         echo '<td>' . $row['user'] . "</td>";
         echo '<td>' . $row['pass'] . "</td>";
         echo '<td>' . $row['futbol'] . "</td>";
         echo '<td>' . $row['baloncesto'] . "</td>";
         echo '<td>' . $row['balonmano'] . "</td>";
         echo '<td>' . $row['sexo'] . "</td>";
         echo '<td>' . $row['provincia'] . "</td>";
         echo '<td>' . $row['comentarios'] . "</td>";
         echo '</tr>';
      }
   }
    
   // Cerrar la conexión a la base de datos
   $pdo = null;
}
catch(PDOException $e) {
   // Mostrar el error
   echo '<p>Error en la base de datos:</p>';
   echo '<p>' . $e->getMessage() . '</p>';
   // Parar la ejecución completa de la página si lo necesitáramos
   // exit();
}
?>

</table>
    
</body>
</html>