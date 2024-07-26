<?php 
include_once '../models/conexao.php';
include_once 'menu.html';
session_start();

// echo $_SESSION['nome_de_usuario'];
// echo $_SESSION['tipo']; 

$sql = "SELECT ser.id_servicos, ser.descricao, ser.data_entrada, ser.data_prevista, ser.data_conclusao, st.descricao, ap.tipo, ca.nome as nomecat, pr.complexidade, 
us.nome FROM `servicos` ser JOIN status st on st.id_status = fk_status_id JOIN aparelhos ap on ap.id_aparelho = fk_aparelho_id JOIN categoria ca on ca.id_categoria = fk_categoria_id 
JOIN prazos pr on pr.complexidade = fk_complexidade_id JOIN usuarios us on us.id_usuarios = fk_usuarios_id"; 

$result  = mysqli_query($conn, $sql);
if(!$result){
    die("error no banco: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css">
</head>
<body class="bg-light text-dark">
    <table class="table rounded-table">
        <tr>
            <th>Codigo</th>
            <th>Descrição</th>
            <th>Entrada</th>
            <th>Previsão de entrega</th>
            <th>Conclusão</th>
            <th>Status</th>
            <th>Aparelho</th>
            <th>Categoria</th>
            <th>Complexidade</th>
            <th>Tecnico</th>
        </tr>
        <?php 
        if(mysqli_num_rows($result)>0){
            if($linha = mysqli_fetch_assoc($result)){

            

        
        ?>

            <tr>
                <td><?php echo $linha['id_servicos']; ?></td>
                <td><?php echo $linha['descricao']; ?></td>
                <td><?php echo $linha['data_entrada']; ?></td>
                <td><?php echo $linha['data_prevista']; ?></td>
                <td><?php echo $linha['data_conclusao']; ?></td>
                <td><?php echo $linha['descricao']; ?></td>
                <td><?php echo $linha['tipo']; ?></td>
                <td><?php echo $linha['nomecat']; ?></td>
                <td><?php echo $linha['complexidade']; ?></td>
                <td><?php echo $linha['nome']; ?></td>
               
               
                
            </tr>











<?php 

            }
        }

?>
    </table>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>