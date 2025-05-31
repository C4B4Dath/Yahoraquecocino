<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Agregar Receta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
      <h2 class="text-center">Agregar Nueva Receta</h2>

      <form class="form-receta bg-white p-1 rounded shadow-sm " action="procesar_receta.php" method="post" enctype="multipart/form-data">
        <!-- Título -->
        <div class="mb-1">
          <label for="titulo" class="form-label">Título de la receta:</label>
          <input type="text" id="titulo" name="titulo" placeholder="Ej: Tacos de Sal" class="form-control" />
        </div>

        <!-- Imagen principal -->
        <div class="mb-2">
          <label for="imagen" class="form-label">Imagen principal:</label>
          <input type="file" id="imagen" name="imagen" class="form-control" />
        </div>

        <!-- Porciones -->
        <div class="mb-3">
          <label for="porciones" class="form-label">Número de porciones:</label>
          <input type="number" id="porciones" name="porciones" min="1" value="1" class="form-control" />
        </div>

        <!-- Ingredientes -->
        <fieldset class="mb-3" id="ingredientes-container">
          <legend>Ingredientes</legend>
          <div class="row g-2 mb-2 ingrediente-item">
            <div class="col-md-8">
              <input type="text" name="ingrediente_nombre[]" placeholder="Nombre del ingrediente" class="form-control" />
            </div>
            <div class="col-md-3">
              <input type="number" name="ingrediente_precio[]" placeholder="Precio $" min="0" step="0.01" class="form-control" />
            </div>
            <div class="col-md-1 d-flex align-items-center">
              <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar-ingrediente">-Eliminar ingrediente</button>
            </div>
          </div>
          <div class="d-flex justify-content-between flex-wrap gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm btn-agregar-ingrediente">+ Agregar ingrediente</button>
          </div>
        </fieldset>

        <!-- Pasos -->
        <fieldset class="mb-3" id="pasos-container">
          <legend>Preparación</legend>
          <div class="mb-2 paso-item">
            <label class="form-label">PASO 1</label>
            <textarea name="instrucciones[]" placeholder="Instrucciones del paso 1" class="form-control mb-2"></textarea>
            <input type="file" name="imagen_paso[]" class="form-control imagen-paso-1" />
            <button type="button" class="btn btn-outline-danger btn-sm mt-1 btn-eliminar-paso">Eliminar paso</button>
          </div>
          <div class="d-flex justify-content-between flex-wrap gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm btn-agregar-paso">+ Agregar paso</button>
          </div>
        </fieldset>

        <!-- Botón de guardar -->
        <button type="submit" class="btn btn-success w-100" >Guardar receta</button>
      </form>
    </main>

    <!-- Publicidad derecha -->
    <aside class="publicidad derecha">Publicidad</aside>
  </div>

  <!-- Bootstrap JS (opcional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- javascript -->
  <script>
    // Mostrar imagen seleccionada
    document.getElementById("imagen").addEventListener("change", function(e) {
      const preview = document.createElement("img");
      preview.style.maxWidth = "100%";
      preview.style.marginTop = "10px";
      const file = e.target.files[0];
      if (file) {
        preview.src = URL.createObjectURL(file);
        const container = e.target.parentElement;
        const existingPreview = container.querySelector("img");
        if (existingPreview) existingPreview.remove();
        container.appendChild(preview);
      }
    });

    // FUNCIONALIDAD PARA INGREDIENTES
    const ingredientesContainer = document.getElementById("ingredientes-container");
    ingredientesContainer.addEventListener("click", function(e) {
      if (e.target.classList.contains("btn-eliminar-ingrediente")) {
        const item = e.target.closest(".ingrediente-item");
        if (item) item.remove();
      }
    });

    ingredientesContainer.querySelector(".btn-agregar-ingrediente").addEventListener("click", function() {
      const newRow = document.createElement("div");
      newRow.classList.add("row", "g-2", "mb-2", "ingrediente-item");
      newRow.innerHTML = `
    <div class="col-md-8">
      <input type="text" name="ingrediente_nombre[]" placeholder="Nombre del ingrediente" class="form-control" />
    </div>
    <div class="col-md-3">
      <input type="number" name="ingrediente_precio[]" placeholder="Precio $" min="0" step="0.01" class="form-control" />
    </div>
    <div class="col-md-1 d-flex align-items-center">
      <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar-ingrediente">- Eliminar ingrediente</button>
    </div>
  `;
      this.closest('div').before(newRow);
    });

    // FUNCIONALIDAD PARA PASOS
    let pasoCounter = 2;
    const pasosContainer = document.getElementById("pasos-container");

    pasosContainer.addEventListener("click", function(e) {
      if (e.target.classList.contains("btn-eliminar-paso")) {
        const paso = e.target.closest(".paso-item");
        if (paso) paso.remove();
      }
    });

pasosContainer.querySelector(".btn-agregar-paso").addEventListener("click", function () {
  const newStep = document.createElement("div");
  newStep.classList.add("mb-2", "paso-item");
  newStep.innerHTML = `
    <label class="form-label">PASO ${pasoCounter}</label>
    <textarea name="instrucciones[]" placeholder="Instrucciones del paso ${pasoCounter}" class="form-control mb-2"></textarea>
    <input type="file" name="imagen_paso[]" class="form-control imagen-paso-${pasoCounter}" />
    <button type="button" class="btn btn-outline-danger btn-sm mt-1 btn-eliminar-paso">Eliminar paso</button>
  `;

  this.closest('div').before(newStep);

  // Vista previa para la nueva imagen
  const inputImg = newStep.querySelector(`.imagen-paso-${pasoCounter}`);
  inputImg.addEventListener("change", function (e) {
    const preview = document.createElement("img");
    preview.style.maxWidth = "100%";
    preview.style.marginTop = "10px";
    const file = e.target.files[0];
    if (file) {
      preview.src = URL.createObjectURL(file);
      const existingPreview = e.target.parentElement.querySelector("img");
      if (existingPreview) existingPreview.remove();
      e.target.parentElement.appendChild(preview);
    }
  });

  pasoCounter++;
});

  </script>
  <script>
    // Vista previa para la imagen del primer paso
    const paso1Img = document.querySelector('.imagen-paso-1');
    paso1Img.addEventListener("change", function(e) {
      const preview = document.createElement("img");
      preview.style.maxWidth = "100%";
      preview.style.marginTop = "10px";
      const file = e.target.files[0];
      if (file) {
        preview.src = URL.createObjectURL(file);
        const existingPreview = e.target.parentElement.querySelector("img");
        if (existingPreview) existingPreview.remove();
        e.target.parentElement.appendChild(preview);
      }
    });
  </script>

</body>

</html>