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
            <form action="insert_data.php" method="post" accept-charset="utf-8">
               <div class="form-group">
                  <label for="usuario">Usuario</label>
                  <input type="text" class="form-control" name="user" id="usuario" placeholder="Nombre de usuario">
               </div>
               <div class="form-group">
                  <label for="password">Contraseña</label>
                  <input type="password" class="form-control" name="pass" id="password" placeholder="Contraseña">
               </div>
               <div class="form-group">
                  <p>Aficiones</p>
                  <div class="form-check">
                     <input class="form-check-input" type="checkbox" name="futbol" id="futbol" />
                     <label class="form-check-label" for="futbol">F&uacute;tbol</label>
                  </div>
                  <div class="form-check">
                     <input class="form-check-input" type="checkbox" name="baloncesto" id="baloncesto" />
                     <label class="form-check-label" for="baloncesto">Baloncesto</label>
                  </div>
                  <div class="form-check">
                     <input class="form-check-input" type="checkbox" name="balonmano" id="balonmano" />
                     <label class="form-check-label" for="balonmano">Balonmano</label>
                  </div>
               </div>
               <div class="form-group">
                  <p>Sexo</p>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="sexo"  value="H" required="required" checked="checked" id="hombre" />
                     <label class="form-check-label" for="hombre">Hombre</label>
                  </div>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="sexo"  value="M" required="required" id="mujer" />
                     <label class="form-check-label" for="mujer">Mujer</label>
                  </div>
               </div>
               <div class="form-group">
                  <p>Provincia</p>
                  <select class="form-control" name="provincia">
                     <option value="14">C&oacute;rdoba</option>
                     <option value="41">Sevilla</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="comentarios">Comentarios</label>
                  <textarea class="form-control" cols="45" rows="5" name="comentarios" placeholder="Introduce tus comentarios..." id="comentarios"></textarea>
               </div>
               <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
         </div>
      </div>
      <a class="btn btn-primary" href="index.php" role="button">Volver al &iacute;ndice</a>
   </div>
</body>
</html>
