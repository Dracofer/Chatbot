<?php

$db = new SQLite3("database.db");


if (!$db) {
    die("Falha na conexão com o banco de dados.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Bem-vindo à Página Inicial</h1>
    
    <p><a href="listar.php">Ver Lista de Produtos</a></p>
</body>
</html>
