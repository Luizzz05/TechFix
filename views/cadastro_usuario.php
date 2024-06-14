
<?php include_once 'menu.html'?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Usuários</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Usuários</h1>
            <button class="btn btn-primary float-end" data-toggle="modal" data-target="#exampleModal" onclick="clearForm()">Adicionar Novo Usuário</button>
            
            <?php
            if (isset($_GET['status'])) {
                if ($_GET['status'] == 'success') {
                    echo '<div class="alert alert-success" role="alert">Operação realizada com sucesso!!</div>';
                } else if ($_GET['status'] == 'error') {
                    echo '<div class="alert alert-danger" role="alert">Erro ao realizar a operação</div>';
                }
            }
            ?>

            <table class='table'>
                <tr>
                    <th>Nome</th>
                    <th>Nome de Usuario</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
                <?php 
                include_once '../models/conexao.php';
                $sql = "SELECT * FROM usuarios";
                $resultado = mysqli_query($conn, $sql);
                if (mysqli_num_rows($resultado) > 0) {
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr'>";
                        echo "<td>" . $row['nome'] . "</td>";
                        echo "<td>" . $row['nome_de_usuario'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['telefone'] . "</td>";
                        echo "<td>" . $row['tipo'] . "</td>";
                        echo "<td>";
                        echo "<button class='btn btn-info' data-toggle='modal' data-target='#exampleModal' onclick='editUser(" . json_encode($row) . ")'>Atualizar</button> ";
                        echo "<form action='../controls/cadastrarUsuario.php' method='POST' style='display:inline-block;'>";
                        echo "<input type='hidden' name='id_usuarios' value='" . $row['id_usuarios'] . "'>";
                        echo "<input type='hidden' name='action' value='delete'>";
                        echo "<button type='submit' class='btn btn-danger' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\")'>Excluir</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhum dado encontrado</td></tr>";
                }
                ?>
            </table>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Novo Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                  <form id="userForm" action="../controls/cadastrarUsuario.php" method="POST">
                      <input type="hidden" id="id_usuarios" name="id_usuarios">
                      <input type="hidden" id="action" name="action" value="add">
                      <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                      </div>
                      <div class="form-group">
                        <label for="nome_de_usuario">Nome de Usuario</label>
                        <input type="text" class="form-control" id="nome_de_usuario" name="nome_de_usuario" required>
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                      </div>
                      <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                      </div>
                      <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" required>
                      </div>
                      <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select class="form-control" id="tipo" name="tipo">
                          <option value="admin">Administrador</option>
                          <option value="user">Técnico</option>
                        </select>
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
    document.getElementById('userForm').reset();
    document.getElementById('action').value = 'add';
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
