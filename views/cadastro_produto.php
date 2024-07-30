<?php include_once 'menu.html';?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Produtos</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body class="bg-light text-dark">

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Produtos</h1>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="flex-grow-1">
                    <?php
                    if (isset($_GET['status'])) {
                        if ($_GET['status'] == 'success') {
                            echo '<div class="alert alert-success mb-0" style="display: inline-block" role="alert">Operação realizada com sucesso!!</div>';
                        } else if ($_GET['status'] == 'error') {
                            echo '<div class="alert alert-danger mb-0" style="display: inline-block" role="alert">Erro ao realizar a operação</div>';
                        }
                    }
                    ?>
                </div>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="clearForm()">Adicionar Novo Produto</button>
                </div>
            </div>

            <?php
            function formatPreco($preco) {
                return 'R$ ' . number_format($preco, 2, ',', '.');
            }
            ?>

            <table class='table rounded-table'>
                <thead>
                    <tr>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Descrição</th>
                        <th class="text-center">Preço</th>
                        <th class="text-center">Estoque</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    include_once '../models/conexao.php';
                    $sql = "SELECT * FROM produtos";
                    $resultado = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            echo "<tr>";
                            echo "<td class='text-center'>" . $row['nome'] . "</td>";
                            echo "<td class='text-center'>" . $row['descricao'] . "</td>";
                            echo "<td class='text-center'>" . formatPreco($row['preco']) . "</td>"; // Aplicar a formatação aqui
                            echo "<td class='text-center'>" . $row['estoque'] . "</td>";
                            echo "<td class='text-center'>";
                            echo "<div class='d-flex justify-content-center'>";
                            echo "<button class='btn action-button edit-button me-2' data-bs-toggle='modal' data-bs-target='#exampleModal' onclick='editClient(" . json_encode($row) . ")'><i class='fas fa-pencil-alt'></i></button> ";
                            echo "<form action='../controls/cadastrarProduto.php' method='POST' style='display:inline-block;'>";
                            echo "<input type='hidden' name='id_produto' value='" . $row['id_produto'] . "'>";
                            echo "<input type='hidden' name='action' value='delete'>";
                            echo "<button type='submit' class='btn action-button delete-button' onclick='return confirm(\"Tem certeza que deseja excluir este cliente?\")'><i class='fas fa-times'></i></button>";
                            echo "</form>";
                            echo "</div>";
                            echo "</td>";
                            
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Nenhum dado encontrado</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Novo Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="productForm" action="../controls/cadastrarProduto.php" method="POST">
                      <input type="hidden" id="id_produto" name="id_produto">
                      <input type="hidden" id="action" name="action" value="add">
                      <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                      </div>
                      <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" required>
                      </div>
                      <div class="mb-3">
                        <label for="preco" class="form-label">Preço</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control" id="preco" name="preco" required>
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="estoque" class="form-label">Estoque</label>
                        <input type="text" class="form-control" id="estoque" name="estoque" required>
                      </div>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

<script>
function clearForm() {
    document.getElementById('productForm').reset();
    document.getElementById('action').value = 'add';
    document.getElementById('exampleModalLabel').innerText = 'Adicionar Novo Produto';
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

document.getElementById('productForm').addEventListener('submit', function(event) {
    var precoField = document.getElementById('preco');
    precoField.value = precoField.value.replace('R$', '').trim().replace(',', '.');
});
</script>

</body>
</html>
