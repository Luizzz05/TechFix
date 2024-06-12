<?php

include_once '..\models\conexao.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nome = $_POST['nome'];
    $user = $_POST['nome_de_usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $cargo = $_POST['tipo'];

    $sql = "INSERT INTO usuarios (nome, nome_de_usuario, email, senha, telefone, tipo) VALUES ('$nome','$use', '$email', '$senha', '$telefone', '$cargo')";
    $resultado = mysqli_query($con, $sql);
    if($resultado == true){
        echo "Cadastrado com Sucesso!!";
    }else{
        echo "Erro ao Cadastrar: " . mysqli_error($con);
    }
}
?>