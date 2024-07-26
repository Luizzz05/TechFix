<?php 
include_once '../models/conexao.php';

$nome_do_Usuario = $_POST['nome_de_usuario'];
$senha = $_POST['senha'];

$consulta = "select * from usuarios where nome_de_usuario = '$nome_do_Usuario'"; 
$resultado = mysqli_query($conn, $consulta);
if($resultado){
   if($registro = mysqli_num_rows($resultado)){
    $linha = mysqli_fetch_assoc($resultado); 
    if(password_verify($senha, $linha['senha'])){
        session_start();
        $_SESSION['nome_de_usuario'] = $linha['nome_de_usuario'];
        $_SESSION['tipo'] = $linha['tipo'];
        header("location: ../views/index2.php");
        exit();
    }else{
        header("location: ../views/login.php");
    }

   } else {
        header("location: ../views/login.php");
   }
}else{
        header("location: ../views/login.php");
}


?>