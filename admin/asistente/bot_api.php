<?php
// 1. Incluir configuración para conexión BD
include('../../app/config.php');

// 2. Consultar las materias reales
$query = $pdo->prepare("SELECT nombre_materia FROM materias WHERE estado = '1'");
$query->execute();
$materias = $query->fetchAll(PDO::FETCH_ASSOC);

// 3. Generar lista de materias permitidas
$lista_materias_bd = ""; 
if(count($materias) > 0){
    foreach ($materias as $m) {
        $lista_materias_bd .= "- " . $m['nombre_materia'] . "\n";
    }
} else {
    $lista_materias_bd = "No hay materias registradas (Sistema Vacío).";
}

// (Opcional) Descomenta esto para ver qué materias está leyendo realmente el sistema
// echo $lista_materias_bd; exit; 

// 4. Validaciones
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Método no permitido";
    exit;
}

if (!isset($_POST['mensaje']) || empty($_POST['mensaje'])) {
    echo "Mensaje vacío";
    exit;
}

$pregunta = $_POST['mensaje'];

// 5. Configuración de API
$api_key = "TU_API_KEY_AQUI"; // Reemplazar por una clave válida

// PROMPT MEJORADO: ASOCIACIÓN FLEXIBLE
$system_content = "
Eres un tutor virtual experto del colegio. Tu objetivo es ayudar a los estudiantes.

CONTEXTO:
El colegio ofrece ÚNICAMENTE las siguientes materias oficiales:
" . $lista_materias_bd . "

INSTRUCCIONES DE LÓGICA Y ASOCIACIÓN:
El usuario hará una pregunta. Debes evaluar si el TEMA de la pregunta encaja dentro de alguna de las materias de la lista.

REGLAS DE FLEXIBILIDAD (MUY IMPORTANTE):
1. ASOCIACIÓN DIRECTA: Si la pregunta es sobre un tema que se estudia dentro de una materia listada, ES VÁLIDO.
   - Ejemplo: Si preguntan '¿Cuánto es 5x5?' y en la lista está 'Algebra' o 'Matemáticas', RESPONDE (porque la aritmética es base del álgebra).
   - Ejemplo: Si preguntan '¿Quién fue Cervantes?' y en la lista está 'Español' o 'Literatura', RESPONDE.
   - Ejemplo: Si preguntan sobre células y en la lista está 'Biología' o 'Ciencias', RESPONDE.

2. SI EL TEMA NO TIENE RELACIÓN:
   - Si preguntan sobre 'Cocina' y no hay materias de gastronomía, RECHAZA.
   - Si preguntan sobre 'Magia' y no hay materias de artes escénicas, RECHAZA.

3. RESPUESTA DE RECHAZO:
   - Di amablemente: 'Ese tema no parece estar relacionado con ninguna de tus materias registradas ([Lista breve de 3 materias relacionadas si existen]).'

4. FORMATO: Sé didáctico, claro y breve.
";

$data = [
    "model" => "gpt-4o-mini",
    "messages" => [
        [
            "role" => "system",
            "content" => $system_content
        ],
        [
            "role" => "user",
            "content" => $pregunta
        ]
    ],
    "max_tokens" => 500
];

// Iniciar CURL
$ch = curl_init("https://api.openai.com/v1/chat/completions");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $api_key"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Desactivar verificación SSL (Para entorno local)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "Error de conexión: " . curl_error($ch);
    exit;
}

curl_close($ch);

$decoded = json_decode($response, true);

if (isset($decoded['error'])) {
    echo "Error API: " . $decoded['error']['message'];
    exit;
}

if (!isset($decoded["choices"][0]["message"]["content"])) {
    echo "Sin respuesta del asistente.";
    exit;
}

// Devolver respuesta
header("Content-Type: text/plain; charset=UTF-8");
echo $decoded["choices"][0]["message"]["content"];
?>