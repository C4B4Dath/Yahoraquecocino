<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>¿Y ahora que cocino?</title>
  <link rel="stylesheet" href="estilos/estilos.css" />
</head>

<body>
  <!-- Header rojo -->
  <header class="header">
    <h1>¿Y ahora que cocino?</h1>
    <p>
      <b><i>Barato y rico, siempre lo aplico</i></b>
    </p>
  </header>

  <!-- Menú superior (íconos azules) -->
  <nav class="menu">
    <div class="menu-item"></div>
    <div class="menu-item"></div>
    <div class="menu-item"></div>
  </nav>

  <div class="contenedor-principal">
    <!-- Publicidad izquierda -->
    <aside class="publicidad izquierda">Publicidad</aside>

    <!-- Contenido principal -->
    <main class="contenido">
      <?php
      $recetas_dir = "recetas/";
      $recetas = scandir($recetas_dir);

      foreach ($recetas as $carpeta) {
        if ($carpeta === "." || $carpeta === "..") continue;

        $ruta_json = "$recetas_dir/$carpeta/{$carpeta}.json";
        if (!file_exists($ruta_json)) continue;

        $json = json_decode(file_get_contents($ruta_json), true);

        // Validación básica
        if (!$json || !isset($json["titulo"], $json["imagen_principal"], $json["ingredientes"])) continue;

        $titulo = htmlspecialchars($json["titulo"]);
        $imagen = "$recetas_dir/$carpeta/" . basename($json["imagen_principal"]);
        $porciones = $json["porciones"] ?? 0;
        $ingredientes = $json["ingredientes"];
        $cantidad_ingredientes = count($ingredientes);

        // Calcular precio total
        $precio_total = 0;
        foreach ($ingredientes as $ing) {
          $precio_total += floatval($ing["precio"]);
        }

        // Calcular promedio de estrellas desde las reseñas
        $resenias = $json["resenias"] ?? [];
        $total_resenias = count($resenias);
        $suma_estrellas = 0;

        foreach ($resenias as $r) {
          $suma_estrellas += intval($r["estrellas"]);
        }

        $promedio_estrellas = $total_resenias > 0 ? round($suma_estrellas / $total_resenias) : 0;

        // Generar estrellas visuales
        $estrellas = str_repeat("★", $promedio_estrellas) . str_repeat("☆", 5 - $promedio_estrellas);

        echo "
    <a href='receta.php?receta=$carpeta' class='receta-link'>
      <div class='receta'>
        <h2 class='titulo'>$titulo</h2>
        <div class='imagen' style='background-image: url($imagen); background-size: cover; height: 150px;'></div>
        <p class='costo'>Costo: \$$precio_total MNX</p>
        <div class='estrellas'>$estrellas</div>
        <p class='resenas'>Reseñas ($total_resenias)</p>
        <p class='ingredientes'>Ingredientes ($cantidad_ingredientes)</p>
      </div>
    </a>";
      }
      ?>
    </main>


    <!-- Publicidad derecha -->
    <aside class="publicidad derecha">Publicidad</aside>
  </div>
</body>

</html>