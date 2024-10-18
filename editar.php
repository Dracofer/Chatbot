<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new SQLite3("database.db");
    if (!$db) {
        die("Falha na conexão com o banco de dados.");
    }

    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];

    $stmt = $db->prepare("UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->bindValue(':nome', $nome, SQLITE3_TEXT);
    $stmt->bindValue(':descricao', $descricao, SQLITE3_TEXT);
    $stmt->bindValue(':preco', $preco, SQLITE3_FLOAT);

    if ($stmt->execute()) {

        header("Location: editar.php?id=".$id);
        exit;
    } else {
        echo "Erro ao atualizar o produto.";
    }

    $db->close();
} elseif (isset($_GET["id"])) {
    $id = $_GET["id"];
    if (!is_numeric($id)) {
        echo "ID do produto não válido.";
        exit;
    }

    $db = new SQLite3("database.db");
    if (!$db) {
        die("Falha na conexão com o banco de dados.");
    }

    $stmt = $db->prepare("SELECT * FROM produtos WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    if ($result) {
        $row = $result->fetchArray();
        if (!$row) {
            echo "Produto não encontrado.";
            exit;
        }

        $nome = $row['nome'];
        $descricao = $row['descricao'];
        $preco = $row['preco'];
    } else {
        echo "Erro ao buscar o produto.";
        exit;
    }

    $db->close();
} else {
    echo "ID do produto não especificado.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Produto</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Editar Produto</h1>

    <form method="POST" action="editar.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="nome">Nome do Produto:</label>
        <input type="text" name="nome" value="<?php echo $nome; ?>" required><br>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" required><?php echo $descricao; ?></textarea><br>

        <label for="preco">Preço:</label>
        <input type="number" step="0.01" name="preco" value="<?php echo $preco; ?>" required><br>

        <input type="submit" value="Atualizar Produto">
    </form>
    <p><a href="listar.php">Voltar para a Lista de Produtos</a></p>
</body>
</html>
