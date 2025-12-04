<?php
require_once __DIR__ . "/config/db_connect.php";

echo json_encode([
    "success" => true,
    "message" => "Servidor activo"
]);
?>
