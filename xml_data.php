<?php
// Cargar las variables de conexión a la base de datos
require_once('connection.php');

// Iniciar el documento XML
$xml = new XMLWriter();
$xml->openURI("php://output");
$xml->startDocument();
$xml->setIndent(true);

// Crear el elemento raíz
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
      while ($row = $db_sentence->fetch()) {
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
         $xml->writeRaw($row['comentarios']);
         $xml->endElement();
         
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

// Finalizar el elemento raíz
$xml->endElement();

// Enviar el documento al navegador
header('Content-type: text/xml');
$xml->flush();
?>