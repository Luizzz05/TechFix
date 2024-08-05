<?php include_once 'menu.html';?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Produtos</title>
    <!-- Adiciona o CSS do Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Produtos</h1>
            <div style="overflow-x:auto;">
                <!-- Formulário de Pesquisa -->
                <div class="pesquisa mb-3">
                    <form method="GET" class="d-flex justify-content-start align-items-center">
                        <div class="input-group input-group-sm" style="max-width: 300px;">
                            <input type="text" class="form-control" name="search" placeholder="Pesquisar por nome" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                            <button class="btn btn-primary" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
                
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

                // Conexão com o banco de dados
                include_once '../models/conexao.php';

                // Parâmetros de paginação
                $itens_por_pagina = 10;
                $pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                $offset = ($pagina_atual - 1) * $itens_por_pagina;

                // Filtro de pesquisa
                $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                // Consulta para obter o número total de registros
                $sql_total = "SELECT COUNT(*) as total FROM produtos WHERE nome LIKE '%$search%'";
                $resultado_total = mysqli_query($conn, $sql_total);
                $total_registros = mysqli_fetch_assoc($resultado_total)['total'];
                $total_paginas = ceil($total_registros / $itens_por_pagina);

                // Consulta com LIMIT, OFFSET e filtro de pesquisa
                $sql = "SELECT * FROM produtos WHERE nome LIKE '%$search%' LIMIT $itens_por_pagina OFFSET $offset";
                $resultado = mysqli_query($conn, $sql);
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
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($row = mysqli_fetch_assoc($resultado)) {
                                echo "<tr>";
                                echo "<td class='text-center'>" . $row['nome'] . "</td>";
                                echo "<td class='text-center'>" . $row['descricao'] . "</td>";
                                echo "<td class='text-center'>" . formatPreco($row['preco']) . "</td>"; // Aplicar a formatação aqui
                                echo "<td class='text-center'>" . $row['estoque'] . "</td>";
                                echo "<td class='text-center'>";
                                echo "<div class='d-flex justify-content-center'>";
                                echo "<button class='btn action-button edit-button me-2' data-bs-toggle='modal' data-bs-target='#exampleModal' onclick='editProduct(" . json_encode($row) . ")'><i class='fas fa-pencil-alt'></i></button>";
                                echo "<form action='../controls/cadastrarProduto.php' method='POST' style='display:inline-block;'>";
                                echo "<input type='hidden' name='id_produto' value='" . $row['id_produto'] . "'>";
                                echo "<input type='hidden' name='action' value='delete'>";
                                echo "<button type='submit' class='btn action-button delete-button' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'><i class='fas fa-times'></i></button>";
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

                <!-- Paginação -->
                <nav aria-label="Navegação de página exemplo">
                    <ul class="pagination justify-content-center">
                        <?php if ($pagina_atual > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?pagina=<?= $pagina_atual - 1 ?>&search=<?= htmlspecialchars($search) ?>">Anterior</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <li class="page-item <?= $i == $pagina_atual ? 'active' : '' ?>">
                                <a class="page-link" href="?pagina=<?= $i ?>&search=<?= htmlspecialchars($search) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($pagina_atual < $total_paginas): ?>
                            <li class="page-item">
                                <a class="page-link" href="?pagina=<?= $pagina_atual + 1 ?>&search=<?= htmlspecialchars($search) ?>">Próximo</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>

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
                            <input type="number" class="form-control" id="estoque" name="estoque" required>
                          </div>
                          <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Adiciona o JavaScript do Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
function clearForm() {
    document.getElementById('productForm').reset();
    document.getElementById('id_produto').value = '';
    document.getElementById('action').value = 'add';
}

function editProduct(product) {
    document.getElementById('id_produto').value = product.id_produto;
    document.getElementById('nome').value = product.nome;
    document.getElementById('descricao').value = product.descricao;
    document.getElementById('preco').value = product.preco;
    document.getElementById('estoque').value = product.estoque;
    document.getElementById('action').value = 'edit';
    document.querySelector('.modal-title').innerText = 'Editar Produto';
}
</script>
</body>
</html>
