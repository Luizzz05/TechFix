<?php
include_once '../models/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descricao = $_POST['descricao'];
    $data_entrada = $_POST['data_entrada'];
    $data_prevista = $_POST['data_prevista'];
    $data_conclusao = $_POST['data_conclusao'];
    $fk_status_id = $_POST['fk_status_id'];
    $fk_aparelho_id = $_POST['fk_aparelho_id'];
    $fk_categoria_id = $_POST['fk_categoria_id'];
    $fk_complexidade_id = $_POST['fk_complexidade_id'];
    $fk_usuarios_id = $_POST['fk_usuarios_id'];

    $sql = "INSERT INTO servicos (descricao, data_entrada, data_prevista, data_conclusao, fk_status_id, fk_aparelho_id, fk_categoria_id, fk_complexidade_id, fk_usuarios_id) VALUES ('$descricao', '$data_entrada', '$data_prevista', '$data_conclusao', '$fk_status_id', '$fk_aparelho_id', '$fk_categoria_id', '$fk_complexidade_id', '$fk_usuarios_id')";

    if (mysqli_query($conn, $sql)) {
        echo "Serviço cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conn);
    }
}
?>
