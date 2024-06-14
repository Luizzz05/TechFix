<?php include_once 'menu.html';?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Produtos</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Produtos</h1>
            <button class="btn btn-primary float-end" data-toggle="modal" data-target="#exampleModal" onclick="clearForm()">Adicionar Novo Produto</button>
            
            <?php
            if (isset($_GET['status'])) {
                if ($_GET['status'] == 'success') {
                    echo '<div class="alert alert-success" style="display: inline-block" role="alert">Operação realizada com sucesso!!</div>';
                } else if ($_GET['status'] == 'error') {
                    echo '<div class="alert alert-danger" style="display: inline-block" role="alert">Erro ao realizar a operação</div>';
                }
            }
            ?>

            <table class='table'>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
                <?php 
                include_once '../models/conexao.php';
                $sql = "SELECT * FROM produtos";
                $resultado = mysqli_query($conn, $sql);
                if (mysqli_num_rows($resultado) > 0) {
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr'>";
                        echo "<td>" . $row['nome'] . "</td>";
                        echo "<td>" . $row['descricao'] . "</td>";
                        echo "<td>" . $row['preco'] . "</td>";
                        echo "<td>" . $row['estoque'] . "</td>";
                        echo "<td>";
                        echo "<button class='btn btn-info' data-toggle='modal' data-target='#exampleModal' onclick='editProduct(" . json_encode($row) . ")'>Atualizar</button> ";
                        echo "<form action='../controls/cadastrarProduto.php' method='POST' style='display:inline-block;'>";
                        echo "<input type='hidden' name='id_produto' value='" . $row['id_produto'] . "'>";
                        echo "<input type='hidden' name='action' value='delete'>";
                        echo "<button type='submit' class='btn btn-danger' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>Excluir</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum dado encontrado</td></tr>";
                }
                ?>
            </table>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Novo Produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                  <form id="productForm" action="../controls/cadastrarProduto.php" method="POST">
                      <input type="hidden" id="id_produto" name="id_produto">
                      <input type="hidden" id="action" name="action" value="add">
                      <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                      </div>
                      <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" required>
                      </div>
                      <div class="form-group">
                        <label for="preco">Preço</label>
                        <input type="text" class="form-control" id="preco" name="preco" required>
                      </div>
                      <div class="form-group">
                        <label for="estoque">Estoque</label>
                        <input type="text" class="form-control" id="estoque" name="estoque" required>
                      </div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
function clearForm() {
    document.getElementById('productForm').reset();
    document.getElementById('action').value = 'add';
}

function editProduct(product) {
    document.getElementById('id_produto').value = product.id_produto;
    document.getElementById('nome').value = product.nome;
    document.getElementById('descricao').value = product.descricao;
    document.getElementById('preco').value = product.preco;
    document.getElementById('estoque').value = product.estoque;
    document.getElementById('action').value = 'update';
    document.getElementById('exampleModalLabel').innerText = 'Atualizar Produto';
}
</script>

</body>
</html>
