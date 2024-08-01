<?php
session_start();
include_once '../models/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturando os dados enviados pelo formulário
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    // Exibir os dados enviados para depuração
    echo "Nome: " . htmlspecialchars($nome) . "<br>";
    echo "Telefone: " . htmlspecialchars($telefone) . "<br>";
    echo "Email: " . htmlspecialchars($email) . "<br>";
    if ($senha !== '') {
        echo "Senha: " . htmlspecialchars($senha) . "<br>";
    }

    // Atualização no banco de dados
    $nome_de_usuario = $_SESSION['nome_de_usuario'];
    $sql = "UPDATE usuarios SET nome = '$nome', telefone = '$telefone', email = '$email'";

    // Se a senha foi preenchida, adiciona a atualização da senha
    if ($senha !== '') {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql .= ", senha = '$senha_hash'";
    }

    $sql .= " WHERE nome_de_usuario = '$nome_de_usuario'";

    if (mysqli_query($conn, $sql)) {
        // Redireciona para perfil.php após a atualização
        header("Location: ../views/perfil.php");
        exit();
    } else {
        echo "Erro ao atualizar o perfil: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
