<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["produto_id"])) {
    $id = $_POST["produto_id"];
    if (!is_numeric($id)) {
        echo "ID do produto não válido.";
        exit;
    }

    $db = new SQLite3("database.db");
    if (!$db) {
        die("Falha na conexão com o banco de dados.");
    }

    $stmt = $db->prepare("DELETE FROM produtos WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);

    if ($stmt->execute()) {
        $db->close();

        header("Location: listar.php");
        exit;
    } else {
        echo "Erro ao excluir o produto.";
    }

    $db->close();
} else {
    $db = new SQLite3("database.db");
    if (!$db) {
        die("Falha na conexão com o banco de dados.");
    }

    $query = "SELECT * FROM produtos";
    $result = $db->query($query);

    if (!$result) {
        die("Erro ao buscar produtos.");
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Excluir Produto</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h1>Excluir Produto</h1>

        <form method="POST" action="excluir.php">
            <label for="produto_id">Selecione o produto a ser excluído:</label>
            <select name="produto_id" required>
                <?php
                while ($row = $result->fetchArray()) {
                    $id = $row['id'];
                    $nome = $row['nome'];
                    echo "<option value='$id'>$nome</option>";
                }
                ?>
            </select>
            <br>
            <input type="submit" value="Confirmar Exclusão">
        </form>

        <p><a href="listar.php">Voltar para a Lista de Produtos</a></p>
    </body>
    </html>
    <?php
    $db->close();
}
?>
