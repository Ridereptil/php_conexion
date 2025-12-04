<?php
// index.php - Página principal de la API
require_once "config/db_connect.php";

header("Content-Type: application/json");

echo json_encode([
    "api" => "DragonBite Backend",
    "version" => "1.0",
    "status" => "online",
    "database" => "connected",
    "endpoints" => [
        "POST /login.php" => "Autenticación de usuarios",
        "POST /register.php" => "Registro de nuevos usuarios",
        "GET /test.php" => "Prueba de conexión",
        "GET /usuarios.php" => "Listar usuarios (protegido)"
    ],
    "timestamp" => date("Y-m-d H:i:s"),
    "environment" => "Railway"
]);
?>