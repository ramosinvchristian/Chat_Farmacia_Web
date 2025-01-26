<?php
// Diccionario de medicamentos
$medicamentos = [
    "Uno" => [
        "mayores" => ["paracetamol 500mg", "paracetamol 1000mg"],
        "menores" => ["ibuprofeno pediátrico"],

        "sin_restriccion" => ["ibuprofeno pediátrico","paracetamol 500mg", "paracetamol 1000mg"],
        "con_restriccion" => ["paracetamol 500mg",""],

        "sin_restriccion" => ["ibuprofeno pediátrico", "paracetamol 500mg", "paracetamol 1000mg"],
        "con_restriccion" => ["paracetamol 500mg", ""]

    ],
    "Dos" => [
        "mayores" => ["benzocaina", "ibuprofeno"],
        "menores" => ["ibuprofeno pediátrico"],
        "sin_restriccion" => ["benzocaina"],
        "con_restriccion" => ["ibuprofeno"]
    ],
    "Tres" => [
        "mayores" => ["antigripal adulto"],
        "menores" => ["antigripal pediátrico"],
        "sin_restriccion" => ["antigripal común"],
        "con_restriccion" => ["descongestionante"]
    ]
];

// Obtener datos del formulario
$sintoma = $_POST['sintoma'];
$edad = (int)$_POST['edad'];
$restricciones = strtolower($_POST['restricciones']);

// Determinar grupo etario
if ($edad >= 18) {
    $grupo = "mayores";
} else {
    $grupo = "menores";
}

// Seleccionar lista de medicamentos según restricciones médicas
if ($restricciones === "sí") {
    $tipo_restriccion = "con_restriccion";
} else {
    $tipo_restriccion = "sin_restriccion";
}

// Validar si hay medicamentos disponibles para el grupo
$recomendados = $medicamentos[$sintoma][$grupo] ?? [];
$recomendados = array_intersect($recomendados, $medicamentos[$sintoma][$tipo_restriccion]);

// Combinar los medicamentos en un formato de texto
$medicamentos_texto = implode(" y ", $recomendados);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recomendación</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        p {
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Recomendación de Medicamentos</h1>
    <?php if (!empty($recomendados)): ?>
        <p>Medicamentos recomendados para el síntoma <strong><?= htmlspecialchars($sintoma) ?></strong>: <?= htmlspecialchars($medicamentos_texto) ?>.</p>
    <?php else: ?>
        <p>No se encontraron medicamentos recomendados para tu caso.</p>
    <?php endif; ?>
    <a href="index.html">Volver</a>

    <link rel="stylesheet" href="../usuario_deficiencia_visual_motriz/estilos.css">
</head>
<body>
    <div class="container">
        <h1>Recomendación de Medicamentos</h1>
        <?php if (!empty($recomendados)): ?>
            <p><strong>Medicamentos recomendados para el síntoma:</strong> <?= htmlspecialchars($sintoma) ?>: <?= htmlspecialchars($medicamentos_texto) ?>.</p>
        <?php else: ?>
            <p><strong>No se encontraron medicamentos recomendados para tu caso.</strong></p>
        <?php endif; ?>
        <a href="index.html" class="btn">Volver</a>
    </div>

    <script>
        // Función para leer el texto en voz alta
        function speakText(text) {
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = "es-ES";
            window.speechSynthesis.speak(utterance);
        }

        // Leer la recomendación final
        speakText("Recomendación procesada. " + document.querySelector('p').textContent);
    </script>

</body>
</html>
