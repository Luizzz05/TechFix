<?php include_once 'menu.html';?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Clientes</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Clientes</h1>
            <button class="btn btn-primary float-end" data-toggle="modal" data-target="#exampleModal" onclick="clearForm()">Adicionar Novo Cliente</button>
            
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
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>CPF</th>
                    <th>Endereço</th>
                    <th>Ações</th>
                </tr>
                <?php 
                include_once '../models/conexao.php';
                $sql = "SELECT * FROM clientes";
                $resultado = mysqli_query($conn, $sql);
                if (mysqli_num_rows($resultado) > 0) {
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr'>";
                        echo "<td>" . $row['nome'] . "</td>";
                        echo "<td>" . $row['telefone'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['cpf'] . "</td>";
                        echo "<td>" . $row['endereco'] . "</td>";
                        echo "<td>";
                        echo "<button class='btn btn-info' data-toggle='modal' data-target='#exampleModal' onclick='editClient(" . json_encode($row) . ")'>Atualizar</button> ";
                        echo "<form action='../controls/cadastrarCliente.php' method='POST' style='display:inline-block;'>";
                        echo "<input type='hidden' name='id_clientes' value='" . $row['id_clientes'] . "'>";
                        echo "<input type='hidden' name='action' value='delete'>";
                        echo "<button type='submit' class='btn btn-danger' onclick='return confirm(\"Tem certeza que deseja excluir este cliente?\")'>Excluir</button>";
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
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Novo Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                  <form id="clientForm" action="../controls/cadastrarCliente.php" method="POST">
                      <input type="hidden" id="id_clientes" name="id_clientes">
                      <input type="hidden" id="action" name="action" value="add">
                      <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                      </div>
                      <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" required>
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                      </div>
                      <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" required>
                      </div>
                      <div class="form-group">
                        <label for="endereco">Endereço</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" required>
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
    document.getElementById('clientForm').reset();
    document.getElementById('action').value = 'add';
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
</script>

</body>
</html>
