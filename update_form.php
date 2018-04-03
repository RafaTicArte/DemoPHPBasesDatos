<?php
/* Procesar las variables de entrada del formulario */
$get_update_id = (isset($_GET['update_id'])) ? trim(strip_tags($_GET['update_id'])) : '';
?>
<!DOCTYPE html>
<html lang="en">
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

            <?php
            /* Recuperar los datos de la base de datos del elemento a actualizar */

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
               $db_sentence = $pdo->prepare('SELECT * FROM '.$db_table.'
                                             WHERE id=:id');
               $db_sentence->bindParam(':id', $get_update_id, PDO::PARAM_INT);
               $db_sentence->execute();

               // Comprobar el resultado de la ejecución
               if ( $db_sentence->errorCode() != 0 ) {
                  // Error en la sentencia
                  $db_error = $db_sentence->errorInfo();
                  echo '<div class="alert alert-danger" role="alert">Error al recuperar los datos: '. $db_error[2] .'</div>';
                  } elseif ( $db_sentence->rowCount() == 0) {
                  // Ningún dato recuperado
                  echo '<div class="alert alert-danger" role="alert">Ese dato no existe en la base de datos</div>';
               } else {
                  // Leer datos recuperados
                  $result = $db_sentence->fetchAll(PDO::FETCH_ASSOC);
                  $row = $result[0];
                  // Añadir los datos al formulario
            ?>

                  <form action="update_data.php?update_id=<?php echo $get_update_id ?>" method="post" accept-charset="utf-8">
                     <div class="form-group">
                        <label for="id">Id</label>
                        <input type="text" disabled="disabled" class="form-control" name="id" id="id" placeholder="Nombre de usuario" value="<?php echo $row['id']; ?>">
                     </div>
                     <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" name="user" id="usuario" placeholder="Nombre de usuario" value="<?php echo $row['user']; ?>">
                     </div>
                     <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" name="pass" id="password" placeholder="Contraseña" value="<?php echo $row['pass']; ?>">
                     </div>
                     <div class="form-group">
                        <p>Aficiones</p>
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" <?php if($row['futbol']=='Futbol') echo 'checked="checked"'; ?> name="futbol" id="futbol" />
                           <label class="form-check-label" for="futbol">F&uacute;tbol</label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" <?php if($row['baloncesto']=='Baloncesto') echo 'checked="checked"'; ?> name="baloncesto" id="baloncesto" />
                           <label class="form-check-label" for="baloncesto">Baloncesto</label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" <?php if($row['balonmano']=='Balonmano') echo 'checked="checked"'; ?> name="balonmano" id="balonmano" />
                           <label class="form-check-label" for="balonmano">Balonmano</label>
                        </div>
                     </div>
                     <div class="form-group">
                        <p>Sexo</p>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="sexo" <?php if($row['sexo']=='H') echo 'checked="checked"'; ?> value="H" required="required" checked="checked" id="hombre" />
                           <label class="form-check-label" for="hombre">Hombre</label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="sexo" <?php if($row['sexo']=='M') echo 'checked="checked"'; ?> value="M" required="required" id="mujer" />
                           <label class="form-check-label" for="mujer">Mujer</label>
                        </div>
                     </div>
                     <div class="form-group">
                        <p>Provincia</p>
                        <select class="form-control" name="provincia">
                           <option value="14" <?php if($row['provincia']=='14') echo 'selected="selected"'; ?>>C&oacute;rdoba</option>
                           <option value="41" <?php if($row['provincia']=='41') echo 'selected="selected"'; ?>>Sevilla</option>
                        </select>
                     </div>
                     <div class="form-group">
                        <label for="comentarios">Comentarios</label>
                        <textarea class="form-control" cols="45" rows="5" name="comentarios" placeholder="Introduce tus comentarios..." id="comentarios"><?php echo $row['comentarios']; ?></textarea>
                     </div>
                     <button type="submit" class="btn btn-primary">Enviar</button>
                  </form>

            <?php
               }

               // Cerrar la conexión a la base de datos
               $pdo = null;
            }
            catch(PDOException $e) {
               // Mostrar el error
               echo '<div class="alert alert-danger" role="alert">Error en la base de datos: ' . $e->getMessage() . '</div>';
               // Parar la ejecución completa de la página si lo necesitáramos
               // exit();
            }
            ?>

         </div>
      </div>
      <a class="btn btn-primary" href="select_data.php" role="button">Volver al listado</a>
      <a class="btn btn-primary" href="index.php" role="button">Volver al &iacute;ndice</a>
   </div>
</body>
</html>
