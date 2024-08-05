<?php include_once 'menu.html';?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Usuários</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Usuários</h1>
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
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="clearForm()">Adicionar Novo Usuário</button>
                    </div>
                </div>

                <?php
                // Conexão com o banco de dados
                include_once '../models/conexao.php';

                // Parâmetros de paginação
                $itens_por_pagina = 10;
                $pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                $offset = ($pagina_atual - 1) * $itens_por_pagina;

                // Filtro de pesquisa
                $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                // Consulta para obter o número total de registros
                $sql_total = "SELECT COUNT(*) as total FROM usuarios WHERE nome LIKE '%$search%'";
                $resultado_total = mysqli_query($conn, $sql_total);
                $total_registros = mysqli_fetch_assoc($resultado_total)['total'];
                $total_paginas = ceil($total_registros / $itens_por_pagina);

                // Consulta com LIMIT, OFFSET e filtro de pesquisa
                $sql = "SELECT * FROM usuarios WHERE nome LIKE '%$search%' LIMIT $itens_por_pagina OFFSET $offset";
                $resultado = mysqli_query($conn, $sql);
                ?>

                <table class='table rounded-table'>
                    <thead>
                        <tr>
                            <th class="text-center">Nome</th>
                            <th class="text-center">Nome de Usuário</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Telefone</th>
                            <th class="text-center">Cargo</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($row = mysqli_fetch_assoc($resultado)) {
                                echo "<tr>";
                                echo "<td class='text-center'>" . $row['nome'] . "</td>";
                                echo "<td class='text-center'>" . $row['nome_de_usuario'] . "</td>";
                                echo "<td class='text-center'>" . $row['email'] . "</td>";
                                echo "<td class='text-center'>" . $row['telefone'] . "</td>";
                                echo "<td class='text-center'>" . $row['tipo'] . "</td>";
                                echo "<td class='text-center'>";
                                echo "<div class='d-flex justify-content-center'>";
                                echo "<button class='btn action-button edit-button me-2' data-bs-toggle='modal' data-bs-target='#exampleModal' onclick='editUser(" . json_encode($row) . ")'><i class='fas fa-pencil-alt'></i></button>";
                                echo "<form action='../controls/cadastrarUsuario.php' method='POST' style='display:inline-block;'>";
                                echo "<input type='hidden' name='id_usuarios' value='" . $row['id_usuarios'] . "'>";
                                echo "<input type='hidden' name='action' value='delete'>";
                                echo "<button type='submit' class='btn action-button delete-button' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\")'><i class='fas fa-times'></i></button>";
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
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar Novo Usuário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form id="userForm" action="../controls/cadastrarUsuario.php" method="POST">
                          <input type="hidden" id="id_usuarios" name="id_usuarios">
                          <input type="hidden" id="action" name="action" value="add">
                          <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                          </div>
                          <div class="mb-3">
                            <label for="nome_de_usuario" class="form-label">Nome de Usuário</label>
                            <input type="text" class="form-control" id="nome_de_usuario" name="nome_de_usuario" required>
                          </div>
                          <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                          </div>
                          <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                          </div>
                          <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" required>
                          </div>
                          <div class="mb-3">
                            <label for="tipo" class="form-label">Cargo</label>
                            <select class="form-select" id="tipo" name="tipo">
                              <option value="Administrador">Administrador</option>
                              <option value="Técnico">Técnico</option>
                            </select>
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
</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
function clearForm() {
    document.getElementById('userForm').reset();
    document.getElementById('id_usuarios').value = '';
    document.getElementById('action').value = 'add';
}

function editUser(user) {
    document.getElementById('id_usuarios').value = user.id_usuarios;
    document.getElementById('nome').value = user.nome;
    document.getElementById('nome_de_usuario').value = user.nome_de_usuario;
    document.getElementById('email').value = user.email;
    document.getElementById('telefone').value = user.telefone;
    document.getElementById('tipo').value = user.tipo;
    document.getElementById('action').value = 'edit';
    document.querySelector('.modal-title').innerText = 'Editar Usuário';
}
</script>
</body>
</html>
