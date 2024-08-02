<?php
include_once '../models/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id_servicos']) ? $_POST['id_servicos'] : null;
    $descricao = $_POST['descricao'];
    $data_entrada = $_POST['data_entrada'];
    $data_prevista = $_POST['data_prevista'];
    $fk_status_id = $_POST['fk_status_id'];
    $fk_aparelho_id = $_POST['fk_aparelho_id'];
    $fk_categoria_id = $_POST['fk_categoria_id'];
    $fk_complexidade_id = $_POST['fk_complexidade_id'];
    $fk_usuarios_id = $_POST['fk_usuarios_id'];
    $action = $_POST['action'];
    
    // Verifica se a data de conclusão foi fornecida
    $data_conclusao = !empty($_POST['data_conclusao']) ? $_POST['data_conclusao'] : NULL;
    // Prepara a query de inserção
    if ($action == 'add') {
    $sql = "INSERT INTO servicos (descricao, data_entrada, data_prevista, data_conclusao, fk_status_id, fk_aparelho_id, fk_categoria_id, fk_complexidade_id, fk_usuarios_id) 
            VALUES ('$descricao', '$data_entrada', '$data_prevista', ";
    }elseif ($action == 'update') {
        $sql = "UPDATE servicos SET descricao= '$descricao', data_entrada= '$data_entrada', data_prevista= '$data_prevista', fk_status_id= '$fk_status_id', fk_aparelho_id= '$fk_aparelho_id', 
        fk_categoria_id= '$fk_categoria_id', fk_complexidade_id= '$fk_complexidade_id', WHERE fk_ususario_id=$fk_usuarios_id";

    } elseif ($action == 'delete') {
        $sql = "DELETE FROM servicos WHERE id_servicos=$id";
    }
    // Adiciona a data de conclusão à query ou NULL, se não fornecida
    $sql .= $data_conclusao ? "'$data_conclusao'" : "NULL";
    $sql .= ", '$fk_status_id', '$fk_aparelho_id', '$fk_categoria_id', '$fk_complexidade_id', '$fk_usuarios_id')";

    $resultado = mysqli_query($conn, $sql);

    
    if ($resultado) {
        header('Location: ../views/servicos.php?status=success');
    } else {
        header('Location: ../views/servicos.php?status=error');
    }
    exit();
}
?>
