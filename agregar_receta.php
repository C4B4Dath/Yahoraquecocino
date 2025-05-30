<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Agregar Receta</title>
  <link rel="stylesheet" href="estilos/agregar.css" />
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
      <h2>Agregar Nueva Receta</h2>
      <form class="form-receta">
        <!-- Título -->
        <label for="titulo">Título de la receta:</label>
        <input type="text" id="titulo" name="titulo" placeholder="Ej: Tacos de Sal" />

        <!-- Imagen principal -->
        <label for="imagen">Imagen principal:</label>
        <input type="file" id="imagen" name="imagen" />

        <!-- Porciones -->
        <label for="porciones">Número de porciones:</label>
        <input type="number" id="porciones" name="porciones" min="1" value="1" />

        <!-- Ingredientes -->
        <fieldset class="ingredientes">
          <legend>Ingredientes</legend>
          <div class="ingrediente">
            <input type="text" name="ingrediente_nombre[]" placeholder="Nombre del ingrediente" />
            <input type="number" name="ingrediente_precio[]" placeholder="Precio $" min="0" step="0.01" />
          </div>
          <!-- Botón para agregar más ingredientes (solo visual) -->
          <button type="button" class="btn-agregar">+ Agregar ingrediente</button>
        </fieldset>

        <!-- Pasos -->
        <fieldset class="preparacion">
          <legend>Preparación</legend>
          <div class="paso">
            <label>PASO 1</label>
            <textarea name="instrucciones[]" placeholder="Instrucciones del paso 1"></textarea>
            <input type="file" name="imagen_paso[]" />
          </div>
          <!-- Botón para agregar más pasos (solo visual) -->
          <button type="button" class="btn-agregar">+ Agregar paso</button>
        </fieldset>

        <!-- Botón de guardar -->
        <button type="submit" class="btn-guardar">Guardar receta</button>
      </form>
    </main>

    <!-- Publicidad derecha -->
    <aside class="publicidad derecha">Publicidad</aside>
  </div>
</body>
</html>
