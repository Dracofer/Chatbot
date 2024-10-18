<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new SQLite3("database.db");
    if (!$db) {
        die("Falha na conexão com o banco de dados.");
    }

    $stmt = $db->prepare("INSERT INTO produtos (nome, descricao, preco) VALUES (:nome, :descricao, :preco)");
    if (!$stmt) {
        die("Erro na preparação da declaração SQL: " . $db->lastErrorMsg());
    }

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];

    $stmt->bindValue(':nome', $nome, SQLITE3_TEXT);
    $stmt->bindValue(':descricao', $descricao, SQLITE3_TEXT);
    $stmt->bindValue(':preco', $preco, SQLITE3_FLOAT);

    if ($stmt->execute()) {
        
        header("Location: listar.php");
        exit; 
    } else {
        echo "Erro ao adicionar o produto.";
    }

    $db->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Criar Novo Produto</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Criar Novo Produto</h1>

    <form method="POST" action="criar.php">
        <label for="nome">Nome do Produto:</label>
        <input type="text" name="nome" required><br>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" required></textarea><br>

        <label for="preco">Preço:</label>
        <input type="number" step="0.01" name="preco" required><br>

        <input type="submit" value="Adicionar Produto">
    </form>
    <p><a href="listar.php">Voltar para a Lista de Produtos</a></p>
</body>
</html>
