<!DOCTYPE html>
<html>
<head>
    <title>Listar Produtos</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Listar Produtos</h1>
    
    <?php
    
    $db = new SQLite3("database.db");

    
    if (!$db) {
        die("Falha na conexão com o banco de dados.");
    }

    
    $query = "SELECT * FROM produtos";
    $result = $db->query($query);
    
    if ($result) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nome</th><th>Descrição</th><th>Preço</th><th>Ações</th></tr>";
        while ($row = $result->fetchArray()) {
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['nome']."</td>";
            echo "<td>".$row['descricao']."</td>";
            echo "<td>".$row['preco']."</td>";
            echo "<td><a href='editar.php?id=".$row['id']."'>Editar</a> | <a href='excluir.php?id=".$row['id']."'>Excluir</a></td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "Não tem produtos na lista.";
    }
    
    $db->close();
    ?>

    <p><a href="criar.php">Adicionar Novo Produto</a></p>
</body>
</html>
