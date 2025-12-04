<?php
// config/db_connect.php - CONFIGURACIÓN CORRECTA PARA INFINITYFREE

function getDBConnection() {
    // Datos EXACTOS de tu panel
    $host = 'sql101.infinityfree.com';
    $dbname = 'if0_40414538_dragonbite';
    $username = 'if0_40414538';
    $password = 'x5l2dH7rxkYnP';

    try {
        // ❗ SIN PUERTO - SI AGREGAS PORT NO FUNCIONA
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        return new PDO($dsn, $username, $password, $options);

    } catch (PDOException $e) {
        error_log("Database Connection Error: " . $e->getMessage());
        echo json_encode(["error" => $e->getMessage()]);
        return null;
    }
}

// CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
?>
