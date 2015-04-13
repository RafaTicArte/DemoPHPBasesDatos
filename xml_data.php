<?php
/* Parámetros de la Base de Datos */ 
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'demophp';
$db_table = 'usuarios';
$db_sentence = '';
$db_error = '';

/* Inicio del documento XML */
$xml = new XMLWriter();
$xml->openURI("php://output");
$xml->startDocument();
$xml->setIndent(true);

/* Elemento raíz */
$xml->startElement('usuarios');

try {
    // Iniciar conexión a la base de datos
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);

    // Modo de error en silencio para chequear nosotros mismos los errores
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );   

    // Recuperar datos de la base de datos
    $db_sentence = $pdo->query('SELECT * FROM '.$db_table);

    // Comprobar el resultado de la ejecución
    if ( $db_sentence == false ) {
        // Error en la sentencia
  		$xml->startElement("error_db");
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
    
    // Cerrar conexión a la base de datos
    $pdo = null;
}
catch(PDOException $e) {
    // Mostrar el error
  	$xml->startElement("error");
	$xml->writeRaw($e->getMessage());
	$xml->endElement();
    // Con exit() paramos la ejecución completa de la página si lo necesitáramos
    // exit();
}

/* Finalizamos el elemento raíz */
$xml->endElement();

/* Enviamos el documento al navegador */
header('Content-type: text/xml');
$xml->flush();
?>