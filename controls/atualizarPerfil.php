<?php
include_once '../models/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : null;
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    // Verifica se todos os campos necessários foram enviados
    if ($id && $nome && $email && $telefone && $endereco) {
        // Atualiza as informações do cliente
        $sql = "UPDATE clientes SET nome='$nome', email='$email', telefone='$telefone', endereco='$endereco' WHERE id_cliente=$id";
        $resultado = mysqli_query($conn, $sql);

        if ($resultado) {
            header('Location: ../views/cadastro_cliente.php?status=success');
        } else {
            header('Location: ../views/cadastro_cliente.php?status=error');
        }
    } else {
        // Se faltar algum campo, redireciona com status de erro
        header('Location: ../views/cadastro_cliente.php?status=error');
    }

    exit();
}
?>
