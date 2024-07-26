<?php
include_once '../models/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $id = isset($_POST['id_usuarios']) ? $_POST['id_usuarios'] : null;
    $nome = $_POST['nome'];
    $user = $_POST['nome_de_usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $cargo = $_POST['tipo'];

    $senha_crip = password_hash($senha, PASSWORD_DEFAULT);

    if ($action == 'add') {
        $sql = "INSERT INTO usuarios (nome, nome_de_usuario, email, senha, telefone, tipo) VALUES ('$nome','$user', '$email', '$senha_crip', '$telefone', '$cargo')";
    } elseif ($action == 'update') {
        $sql = "UPDATE usuarios SET nome='$nome', nome_de_usuario='$user', email='$email', senha='$senha_crip', telefone='$telefone', tipo='$cargo' WHERE id_usuarios=$id";
    } elseif ($action == 'delete') {
        $sql = "DELETE FROM usuarios WHERE id_usuarios=$id";
    }

    $resultado = mysqli_query($conn, $sql);
    if ($resultado) {
        header('Location: ../views/cadastro_usuario.php?status=success');
    } else {
        header('Location: ../views/cadastro_usuario.php?status=error');
    }
    exit();
}
?>
