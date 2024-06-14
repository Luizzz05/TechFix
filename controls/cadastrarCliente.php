<?php 

include_once '..\models\conexao.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $action = $_POST['action'];
    $id = isset($_POST['id_clientes']) ? $_POST['id_clientes'] : null;
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];

    if ($action == 'add') {
        $sql = "INSERT INTO clientes (nome, telefone, email, cpf, endereco) VALUES ('$nome','$telefone', '$email', '$cpf', '$endereco')";
    } elseif ($action == 'update') {
        $sql = "UPDATE clientes SET nome='$nome', telefone='$telefone', email='$email', cpf='$cpf', endereco='$endereco' WHERE id_clientes=$id";
    } elseif ($action == 'delete') {
        $sql = "DELETE FROM clientes WHERE id_clientes=$id";
    }

    $resultado = mysqli_query($conn, $sql);
    if ($resultado) {
        header('Location: ../views/cadastro_cliente.php?status=success');
    } else {
        header('Location: ../views/cadastro_cliente.php?status=error');
    }
    exit();
}

?>