<?php include_once 'menu.html';?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Clientes</title>
    <!-- Adiciona o CSS do Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Clientes</h1>
            <div style="overflow-x:auto;">
                         <!-- Formulário de Pesquisa -->
            <div class="pesquisa">
                <form method="GET" class="d-flex justify-content-start align-items-center">
                <div class="input-group input-group-sm" style="max-width: 300px;">
                    <input type="text" class="form-control" name="search" placeholder="Pesquisar por nome" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button class="btn btn-primary " type="submit">
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
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="clearForm()">Adicionar Novo Cliente</button>
                </div>
            </div>

 

            <?php
            function formatCPF($cpf) {
                return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
            }

            function formatTelefone($telefone) {
                return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 4) . '-' . substr($telefone, 6, 4);
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
            $sql_total = "SELECT COUNT(*) as total FROM clientes WHERE nome LIKE '%$search%'";
            $resultado_total = mysqli_query($conn, $sql_total);
            $total_registros = mysqli_fetch_assoc($resultado_total)['total'];
            $total_paginas = ceil($total_registros / $itens_por_pagina);

            // Consulta com LIMIT, OFFSET e filtro de pesquisa
            $sql = "SELECT * FROM clientes WHERE nome LIKE '%$search%' LIMIT $itens_por_pagina OFFSET $offset";
            $resultado = mysqli_query($conn, $sql);
            ?>

            <table class='table rounded-table'>
                <thead>
                    <tr>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Telefone</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">CPF</th>
                        <th class="text-center">Endereço</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    if (mysqli_num_rows($resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            echo "<tr>";
                            echo "<td class='text-center'>" . $row['nome'] . "</td>";
                            echo "<td class='text-center'>" . formatTelefone($row['telefone']) . "</td>"; // Aplicar a formatação aqui
                            echo "<td class='text-center'>" . $row['email'] . "</td>";
                            echo "<td class='text-center'>" . formatCPF($row['cpf']) . "</td>"; // Aplicar a formatação aqui
                            echo "<td class='text-center'>" . $row['endereco'] . "</td>";
                            echo "<td class='text-center'>";
                            echo "<div class='d-flex justify-content-center'>";
                            echo "<button class='btn action-button edit-button me-2' data-bs-toggle='modal' data-bs-target='#exampleModal' onclick='editClient(" . json_encode($row) . ")'><i class='fas fa-pencil-alt'></i></button> ";
                            echo "<form action='../controls/cadastrarCliente.php' method='POST' style='display:inline-block;'>";
                            echo "<input type='hidden' name='id_clientes' value='" . $row['id_clientes'] . "'>";
                            echo "<input type='hidden' name='action' value='delete'>";
                            echo "<button type='submit' class='btn action-button delete-button' onclick='return confirm(\"Tem certeza que deseja excluir este cliente?\")'><i class='fas fa-times'></i></button>";
                            echo "</form>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Nenhum dado encontrado</td></tr>";
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
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Novo Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="clientForm" action="../controls/cadastrarCliente.php" method="POST">
                      <input type="hidden" id="id_clientes" name="id_clientes">
                      <input type="hidden" id="action" name="action" value="add">
                      <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                      </div>
                      <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" required>
                      </div>
                      <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                      </div>
                      <div class="mb-3">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" required>
                      </div>
                      <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" required>
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

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
function clearForm() {
    document.getElementById('clientForm').reset();
    document.getElementById('action').value = 'add';
    document.getElementById('exampleModalLabel').innerText = 'Adicionar Novo Cliente';
}

function editClient(client) {
    document.getElementById('id_clientes').value = client.id_clientes;
    document.getElementById('nome').value = client.nome;
    document.getElementById('telefone').value = client.telefone;
    document.getElementById('email').value = client.email;
    document.getElementById('cpf').value = client.cpf;
    document.getElementById('endereco').value = client.endereco;
    document.getElementById('action').value = 'update';
    document.getElementById('exampleModalLabel').innerText = 'Atualizar Cliente';
}

document.getElementById('clientForm').addEventListener('submit', function(event) {
    var cpfField = document.getElementById('cpf');
    cpfField.value = cpfField.value.replace(/\D/g, '');
});
</script>

</body>
</html>
