<?php include_once 'menu.html'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cliente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body class="bg-light text-dark">
    <div class="container">
        <h1 class="mt-5">Selecione ou Cadastre um Cliente</h1>
        
        <!-- Formulário para Selecionar Cliente -->
        <form id="selectClientForm" class="mt-3">
            <div class="form-group">
                <label for="clients">Selecione um Cliente:</label>
                <select id="clients" name="clients" class="form-control" onchange="checkClient()">
                    <option value="" disabled selected>Escolha um cliente</option>
                    <?php
                    include_once '../models/conexao.php';
                    $result = mysqli_query($conn, "SELECT id_clientes, nome FROM clientes");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id_clientes']}'>{$row['nome']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="button" class="btn btn-primary" onclick="submitClientForm()">Continuar</button>
            <button type="button" class="btn btn-secondary" onclick="showNewClientForm()">Novo Cliente</button>
        </form>

        <!-- Formulário para Cadastro de Novo Cliente -->
        <form id="newClientForm" style="display: none;" method="POST" class="mt-3">
            <h2>Cadastro de Novo Cliente</h2>
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="tel" class="form-control" id="telefone" name="telefone" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf" required>
            </div>
            <div class="form-group">
                <label for="endereco">Endereço:</label>
                <input type="text" class="form-control" id="endereco" name="endereco" required>
            </div>
            <button type="submit" class="btn btn-success">Cadastrar</button>
            <button type="button" class="btn btn-secondary" onclick="showSelectClientForm()">Cancelar</button>
        </form>

        <!-- Formulário para Cadastro de Aparelho -->
        <form id="aparelhoForm" style="display: none;" method="POST" class="mt-3">
            <h2>Cadastro de Aparelho</h2>
            <input type="hidden" id="fk_clientes_id" name="fk_clientes_id">
            <div class="form-group">
                <label for="clientName">Cliente:</label>
                <input type="text" class="form-control" id="clientName" name="clientName" readonly>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <input type="text" class="form-control" id="tipo" name="tipo" required>
            </div>
            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" class="form-control" id="marca" name="marca" required>
            </div>
            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" class="form-control" id="modelo" name="modelo" required>
            </div>
            <div class="form-group">
                <label for="numero_serie">Número de Série:</label>
                <input type="text" class="form-control" id="numero_serie" name="numero_serie" required>
            </div>
            <button type="submit" class="btn btn-success">Cadastrar Aparelho</button>
            <button type="button" class="btn btn-secondary" onclick="showSelectClientForm()">Cancelar</button>
        </form>
    </div>

    <script>
        function checkClient() {
            var clientSelect = document.getElementById("clients");
            var newClientForm = document.getElementById("newClientForm");

            if (clientSelect.value === "new") {
                newClientForm.style.display = "block";
                document.getElementById("selectClientForm").style.display = "none";
            } else {
                newClientForm.style.display = "none";
            }
        }

        function submitClientForm() {
            var clientSelect = document.getElementById("clients");
            var aparelhoForm = document.getElementById("aparelhoForm");
            var clientNameInput = document.getElementById("clientName");
            var fkClientesIdInput = document.getElementById("fk_clientes_id");

            if (clientSelect.value !== "new") {
                var clientName = clientSelect.options[clientSelect.selectedIndex].text;
                clientNameInput.value = clientName;
                fkClientesIdInput.value = clientSelect.value;
                document.getElementById("selectClientForm").style.display = "none";
                aparelhoForm.style.display = "block";
            }
        }

        function showNewClientForm() {
            document.getElementById("newClientForm").style.display = "block";
            document.getElementById("selectClientForm").style.display = "none";
        }

        function showSelectClientForm() {
            document.getElementById("newClientForm").style.display = "none";
            document.getElementById("selectClientForm").style.display = "block";
            document.getElementById("aparelhoForm").style.display = "none";
        }

        // Interceptar o envio do formulário de novo cliente
        document.getElementById("newClientForm").addEventListener("submit", function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch("../controls/cadastrarCliente.php", {
                method: "POST",
                body: formData
            }).then(response => response.text())
              .then(result => {
                  // Redirecionar para a página de serviços após o cadastro bem-sucedido
                  window.location.href = "../views/servicos.php";
              }).catch(error => {
                  console.error('Erro:', error);
                  alert('Ocorreu um erro ao cadastrar o cliente.');
              });
        });

        // Interceptar o envio do formulário de novo aparelho
        document.getElementById("aparelhoForm").addEventListener("submit", function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch("../controls/cadastrarAparelho.php", {
                method: "POST",
                body: formData
            }).then(response => response.text())
              .then(result => {
                  alert("Aparelho cadastrado com sucesso!");
                  showSelectClientForm();
              }).catch(error => {
                  console.error('Erro:', error);
                  alert('Ocorreu um erro ao cadastrar o aparelho.');
              });
        });
    </script>
</body>
</html>
