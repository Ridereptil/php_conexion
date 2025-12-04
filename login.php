<?php
require_once __DIR__ . "/config/db_connect.php";

$pdo = getDBConnection();
if (!$pdo) {
    echo json_encode(["success" => false, "message" => "Error en conexión a la DB"]);
    exit();
}

// Leer JSON del cuerpo
$data = json_decode(file_get_contents("php://input"), true);

$email = $data["email"] ?? "";
$password = $data["password"] ?? "";

if (empty($email) || empty($password)) {
    echo json_encode(["success" => false, "message" => "Campos vacíos"]);
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT id, nombre, email, telefono, password FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        echo json_encode(["success" => false, "message" => "Usuario no encontrado"]);
        exit();
    }

    // Comparar passwords (en texto plano o hash según tu DB)
    if (!password_verify($password, $user["password"]) && $password !== $user["password"]) {
        echo json_encode(["success" => false, "message" => "Contraseña incorrecta"]);
        exit();
    }

    // Respuesta JSON
    echo json_encode([
        "success" => true,
        "message" => "Login exitoso",
        "user" => [
            "id" => $user["id"],
            "nombre" => $user["nombre"],
            "email" => $user["email"],
            "telefono" => $user["telefono"]
        ]
    ]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error en servidor"]);
}
?>
