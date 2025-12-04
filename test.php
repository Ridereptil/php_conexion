<?php
// test.php - Verificar que todo funciona
require_once "config/db_connect.php";

try {
    $pdo = getDBConnection();
    
    // Probar consulta simple
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
    $result = $stmt->fetch();
    
    // Probar conexión a tabla específica
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    echo json_encode([
        "success" => true,
        "message" => "✅ Conexión exitosa a Railway MySQL",
        "database" => "dragonbite",
        "total_usuarios" => $result['total'],
        "tablas" => $tables,
        "host" => "shinkansen.proxy.rlwy.net",
        "timestamp" => date("Y-m-d H:i:s")
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "❌ Error de conexión",
        "error" => $e->getMessage()
    ]);
}
?>