<?php 

include_once '..\models\conexao.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $action = $_POST['action'];
    $id = isset($_POST['id_produto']) ? $_POST['id_produto'] : null;
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];

    if ($action == 'add') {
        $sql = "INSERT INTO produtos (nome, descricao, preco, estoque) VALUES ('$nome','$descricao', '$preco', '$estoque')";
    } elseif ($action == 'update') {
        $sql = "UPDATE produtos SET nome='$nome', descricao='$descricao', preco='$preco', estoque='$estoque' WHERE id_produto=$id";
    } elseif ($action == 'delete') {
        $sql = "DELETE FROM produtos WHERE id_produto=$id";
    }

    $resultado = mysqli_query($conn, $sql);
    if ($resultado) {
        header('Location: ../views/cadastro_produto.php?status=success');
    } else {
        header('Location: ../views/cadastro_produto.php?status=error');
    }
    exit();
}

?>