<?php
// Validar campos obligatorios
if (!isset($_POST['titulo']) || empty(trim($_POST['titulo']))) {
    die("El título de la receta es obligatorio.");
}

$titulo = trim($_POST['titulo']);
$porciones = isset($_POST['porciones']) ? intval($_POST['porciones']) : 1;

// Ruta base
$nombreCarpeta = preg_replace('/[^A-Za-z0-9_\-]/', '_', $titulo);
$carpeta = 'recetas/' . $nombreCarpeta;
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}

// Guardar imagen principal
$imagenPrincipalPath = '';
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    $nombreArchivo = 'principal.' . $ext;
    $rutaDestino = $carpeta . '/' . $nombreArchivo;

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
        $imagenPrincipalPath = $rutaDestino;
    }
}

// Procesar ingredientes
$ingredientes = [];
if (isset($_POST['ingrediente_nombre']) && is_array($_POST['ingrediente_nombre'])) {
    foreach ($_POST['ingrediente_nombre'] as $i => $nombre) {
        if (!empty(trim($nombre))) {
            $precio = isset($_POST['ingrediente_precio'][$i]) ? floatval($_POST['ingrediente_precio'][$i]) : 0.0;
            $ingredientes[] = [
                'nombre' => trim($nombre),
                'precio' => $precio
            ];
        }
    }
}

// Procesar pasos
$pasos = [];
if (isset($_POST['instrucciones']) && is_array($_POST['instrucciones'])) {
    foreach ($_POST['instrucciones'] as $i => $instruccion) {
        if (!empty(trim($instruccion))) {
            $paso = [
                'paso' => "PASO " . ($i + 1),
                'instrucciones' => trim($instruccion),
                'imagen' => ''
            ];

            // Imagen del paso
            if (isset($_FILES['imagen_paso']['name'][$i]) && $_FILES['imagen_paso']['error'][$i] === UPLOAD_ERR_OK) {
                $extPaso = pathinfo($_FILES['imagen_paso']['name'][$i], PATHINFO_EXTENSION);
                $nombrePasoArchivo = "paso_" . ($i + 1) . "." . $extPaso;
                $rutaPaso = $carpeta . '/' . $nombrePasoArchivo;

                if (move_uploaded_file($_FILES['imagen_paso']['tmp_name'][$i], $rutaPaso)) {
                    $paso['imagen'] = $rutaPaso;
                }
            }

            $pasos[] = $paso;
        }
    }
}

// Construir receta final
$receta = [
    'titulo' => $titulo,
    'imagen_principal' => $imagenPrincipalPath,
    'porciones' => $porciones,
    'ingredientes' => $ingredientes,
    'preparacion' => $pasos,
    'resenias' => []
];

// Guardar JSON con el nombre de la carpeta
$archivoJson = $carpeta . '/' . $nombreCarpeta . '.json';
file_put_contents($archivoJson, json_encode($receta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "Receta guardada correctamente en: <a href='$archivoJson' target='_blank'>$archivoJson</a>";
