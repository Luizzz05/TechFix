<?php 

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $action = $_POST['action'];
    $id = isset($_POST['id_aparelho']) ? $_POST['id_aparelho'] : null;
    $tipo = $_POST['tipo'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $serie = $_POST['numero_serie'];

    $sql = "INSERT INTO aparelhos (tipo, marca, modelo, numero_serie) VALUES ('$tipo','$marca', '$modelo', '$numero_serie')";
    if($resultado == true){
        echo "Cadastrado com Sucesso";
    }else{
        echo "Erro ao cadastrar" . mysqli_error($conn);
    }
}
    exit();
?>
