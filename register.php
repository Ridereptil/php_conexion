<?php
require_once "config/db_connect.php";

/* =======================================
   HACK ANTI-FIREWALL INFINITYFREE
======================================= */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, User-Agent, Accept");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

header("X-Requested-With: XMLHttpRequest");
header("User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122 Safari/537.36");
header("Accept: application/json");

sleep(1); // ⚠ Delay para que no parezca bot

// ===============================
// LEE CUERPO MANUAL (NO JSON PURO)
// ===============================
$raw = file_get_contents("php://input");

if (!$raw) {
    echo json_encode(["success" => false, "message" => "No se recibió contenido"]);
    exit;
}

// Intentar decodificar JSON
$input = json_decode($raw, true);

if (!is_array($input)) {
    echo json_encode(["success" => false, "message" => "JSON inválido"]);
    exit;
}

// ==========================
// Obtener variables
// ==========================
$nombre = trim($input["nombre"] ?? "");
$email = trim($input["email"] ?? "");
$password = trim($input["password"] ?? "");
$telefono = trim($input["telefono"] ?? "");
$direccion = trim($input["direccion"] ?? "");

// Validación básica
if (!$nombre || !$email || !$password || !$telefono) {
    echo json_encode(["success" => false, "message" => "Faltan datos"]);
    exit;
}

try {
    $db = getDBConnection();

    // Verificar email
    $query = $db->prepare("SELECT id FROM usuarios WHERE email = ?");
    $query->execute([$email]);

    if ($query->rowCount() > 0) {
        echo json_encode(["success" => false, "message" => "El email ya existe"]);
        exit;
    }

    // Insertar usuario
    $query = $db->prepare("INSERT INTO usuarios (nombre, email, password, telefono, direccion)
                           VALUES (?, ?, ?, ?, ?)");

    $query->execute([
        $nombre,
        $email,
        password_hash($password, PASSWORD_DEFAULT),
        $telefono,
        $direccion
    ]);

    $id = $db->lastInsertId();

    echo json_encode([
        "success" => true,
        "message" => "Registro exitoso",
        "data" => [
            "id" => $id,
            "nombre" => $nombre,
            "email" => $email,
            "telefono" => $telefono
        ]
    ]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error interno"]);
}

