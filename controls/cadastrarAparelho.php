<?php
include_once '../models/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $numero_serie = $_POST['numero_serie'];
    $fk_clientes_id = $_POST['fk_clientes_id'];

    $sql = "INSERT INTO aparelhos (tipo, marca, modelo, numero_serie, fk_clientes_id) VALUES ('$tipo', '$marca', '$modelo', '$numero_serie', '$fk_clientes_id')";

    if (mysqli_query($conn, $sql)) {
        $aparelho_id = mysqli_insert_id($conn);
        $response = array("status" => "success", "aparelho_id" => $aparelho_id, "tipo" => $tipo, "modelo" => $modelo);
        echo json_encode($response);
    } else {
        $response = array("status" => "error", "message" => "Erro ao cadastrar: " . mysqli_error($conn));
        echo json_encode($response);
    }
}
?>
