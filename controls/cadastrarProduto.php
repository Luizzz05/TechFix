<?php 

include_once '..\models\conexao.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];

    $sql = "INSERT INTO usuarios (nome, descricao, preco, estoque) VALUES ('$nome','$descricao', '$preco', '$estoque')";
    $resultado = mysqli_query($conn, $sql);
    if($resultado == true){
        echo "Cadastrado com Sucesso";
    }else{
        echo "Erro ao cadastrar" . mysqli_error($conn);
    }
}

?>