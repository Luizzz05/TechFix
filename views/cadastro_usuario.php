<?php include_once 'menu.html';?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Usuários</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Usuários</h1>
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

            <table class='table rounded-table'>
                <thead>
                    <tr>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Nome de Usuario</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Telefone</th>
                        <th class="text-center">Cargo</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    include_once '../models/conexao.php';
                    $sql = "SELECT * FROM usuarios";
                    $resultado = mysqli_query($conn, $sql);
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
                            echo "<button class='btn btn-primary btn-rounded' data-bs-toggle='modal' data-bs-target='#exampleModal' onclick='editUser(" . json_encode($row) . ")'>Atualizar</button> ";
                            echo "<form action='../controls/cadastrarUsuario.php' method='POST' style='display:inline-block;'>";
                            echo "<input type='hidden' name='id_usuarios' value='" . $row['id_usuarios'] . "'>";
                            echo "<input type='hidden' name='action' value='delete'>";
                            echo "<button type='submit' class='btn btn-danger btn-rounded' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\")'>Excluir</button>";
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
                        <label for="tipo" class="form-label">Tipo</label>
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

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

<script>
function clearForm() {
    document.getElementById('userForm').reset();
    document.getElementById('action').value = 'add';
    document.getElementById('exampleModalLabel').innerText = 'Adicionar Novo Usuário';
}

function editUser(user) {
    document.getElementById('id_usuarios').value = user.id_usuarios;
    document.getElementById('nome').value = user.nome;
    document.getElementById('nome_de_usuario').value = user.nome_de_usuario;
    document.getElementById('email').value = user.email;
    document.getElementById('senha').value = user.senha;
    document.getElementById('telefone').value = user.telefone;
    document.getElementById('tipo').value = user.tipo;
    document.getElementById('action').value = 'update';
    document.getElementById('exampleModalLabel').innerText = 'Atualizar Usuário';
}
</script>

</body>
</html>