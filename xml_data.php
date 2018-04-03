<?php
/* Procesar las variables de entrada */
$get_file = (isset($_GET['file'])) ? trim(strip_tags($_GET['file'])) : '';

// Cargar las variables de conexión a la base de datos
require_once('connection.php');

// Iniciar el documento XML
$xml = new XMLWriter();
$xml->openURI("php://output");
$xml->startDocument();
$xml->setIndent(true);

// Crear el elemento raíz 'usuarios'
$xml->startElement('usuarios');

try {
   // Iniciar la conexión a la base de datos
   $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);

   // Asginar el modo de error Silencio para chequear nosotros mismos los errores
   $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );

   // Recuperar datos con parámetros preparados
   // bindParam para asignar valores en el momento de la ejecución
   $db_sentence = $pdo->prepare('SELECT * FROM '.$db_table);
   $db_sentence->execute();

   // Comprobar el resultado de la ejecución
   if ( $db_sentence->errorCode() != 0 ) {
      // Error en la sentencia
      $xml->startElement("error_db");
      $db_error = $db_sentence->errorInfo();
      $xml->writeRaw($db_error[2]);
      $xml->endElement();
    } elseif ( $db_sentence->rowCount() == 0) {
      // Ningún dato recuperado
      $xml->startElement("sin_usuarios");
      $xml->endElement();
    } else {
      // Leer datos recuperados
      $result = $db_sentence->fetchAll(PDO::FETCH_ASSOC);
      foreach ($result as $row) {
         // Crear el elemento 'usuario'
         $xml->startElement("usuario");
         $xml->writeAttribute('id', $row['id']);

         $xml->startElement("nombre");
         $xml->writeRaw($row['user']);
         $xml->endElement();

         $xml->startElement("contraseña");
         $xml->writeRaw($row['pass']);
         $xml->endElement();

         $xml->startElement("aficiones");
         if ($row['futbol'] != '') {
            $xml->startElement("futbol");
            $xml->endElement();
         }
         if ($row['baloncesto'] != '') {
            $xml->startElement("baloncesto");
            $xml->endElement();
         }
         if ($row['balonmano'] != '') {
            $xml->startElement("balonmano");
            $xml->endElement();
         }
         $xml->endElement();

         $xml->startElement("sexo");
         $xml->writeRaw($row['sexo']);
         $xml->endElement();

         $xml->startElement("provincia");
         $xml->writeRaw($row['provincia']);
         $xml->endElement();

         $xml->startElement("comentarios");
         $xml->writeRaw(html_entity_decode($row['comentarios'], ENT_HTML5, 'UTF-8'));
         $xml->endElement();

         // Finalizar el elemento 'usuario'
         $xml->endElement();
        }
    }

   // Cerrar la conexión a la base de datos
   $pdo = null;
}
catch(PDOException $e) {
   // Mostrar el error
   $xml->startElement("error");
   $xml->writeRaw($e->getMessage());
   $xml->endElement();
   // Parar la ejecución completa de la página si lo necesitáramos
   // exit();
}

// Finalizar el elemento raíz 'usuarios'
$xml->endElement();

// Enviar el documento al navegador
if ( $get_file == 'download' ) {
   // Esta cabecera sólo es necesaria si se desea descargar como archivo
   header('Content-disposition: attachment; filename=datos.xml');
}
header('Content-type: application/xml;charset=utf-8');
$xml->flush();
?>
