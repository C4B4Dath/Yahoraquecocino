<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Receta seleccionada</title>
  <link rel="stylesheet" href="estilos/receta.css" />
</head>
<body>
  <!-- Header rojo -->
  <header class="header">
    <h1>¿Y ahora que cocino?</h1>
    <p><b><i>Barato y rico, siempre lo aplico</i></b></p>
  </header>

  <div class="contenedor-principal">
    <!-- Publicidad izquierda -->
    <aside class="publicidad izquierda">Publicidad</aside>

    <!-- Contenido principal -->
    <main class="contenido">
      <?php
      if (isset($_GET["receta"])) {
        $nombre = $_GET["receta"];
        $ruta_json = "recetas/$nombre/{$nombre}.json";

        if (file_exists($ruta_json)) {
          $json = json_decode(file_get_contents($ruta_json), true);

          $titulo = htmlspecialchars($json["titulo"]);
          $imagen_principal = "recetas/$nombre/" . basename($json["imagen_principal"]);
          $porciones = $json["porciones"];
          $ingredientes = $json["ingredientes"];
          $preparacion = $json["preparacion"];
          $resenias = $json["resenias"] ?? [];

          // Calcular precio total
          $precio_total = 0;
          foreach ($ingredientes as $ing) {
            $precio_total += floatval($ing["precio"]);
          }

          echo "<div class='receta'>
            <h2 class='titulo-receta'>$titulo</h2>

            <div class='contenido-receta'>
              <img src='$imagen_principal' alt='Imagen de $titulo' class='imagen-receta' />
              
              <div class='info-receta'>
                <ul class='ingredientes'>
                <p><b>Ingredientes</b></p>";
          
          foreach ($ingredientes as $ing) {
            $nombre_ing = htmlspecialchars($ing["nombre"]);
            $precio = number_format($ing["precio"], 2);
            echo "<li>$nombre_ing - \$$precio</li>";
          }

          echo "<hr><li><strong>Total: \$$precio_total</strong></li>
                </ul>
              </div>
            </div>
            <p><strong>Porciones:</strong> $porciones</p>";

          // Sección de preparación
          foreach ($preparacion as $paso) {
            $paso_titulo = htmlspecialchars($paso["paso"]);
            $instrucciones = htmlspecialchars($paso["instrucciones"]);
            $imagen_paso = $paso["imagen"];
            echo "<section class='preparacion'>
              <h3>$paso_titulo</h3>
              <p>$instrucciones</p>
              <img src='$imagen_paso' alt='Preparación $paso_titulo' class='imagen-preparacion' />
            </section>";
          }

          // Reseñas
          if (!empty($resenias)) {
            echo "<section class='resenias'>
              <h3>Reseñas</h3>";
            foreach ($resenias as $r) {
              $usuario = htmlspecialchars($r["usuario"]);
              $texto = htmlspecialchars($r["resenia"]);
              $estrellas = str_repeat("★", intval($r["estrellas"])) . str_repeat("☆", 5 - intval($r["estrellas"]));
              echo "<div class='resenia'>
                <p><strong>$usuario</strong>: $texto</p>
                <div class='estrellas'>$estrellas</div>
              </div>";
            }
            echo "</section>";
          }

          echo "</div>";
        } else {
          echo "<p>Receta no encontrada.</p>";
        }
      } else {
        echo "<p>No se especificó ninguna receta.</p>";
      }
      ?>
    </main>

    <!-- Publicidad derecha -->
    <aside class="publicidad derecha">Publicidad</aside>
  </div>
</body>
</html>
