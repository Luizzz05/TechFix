<?php include_once 'menu.html';?>
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
                    <!-- Adicionar clientes existentes dinamicamente -->
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
            if (clientSelect.value !== "new") {
                alert("Cliente selecionado: " + clientSelect.options[clientSelect.selectedIndex].text);
                // Aqui você pode adicionar a lógica para redirecionar ou realizar alguma ação com o cliente selecionado
            } else {
                // Se a opção "Novo Cliente" estiver selecionada, o formulário de cadastro já estará visível
            }
        }

        function showNewClientForm() {
            document.getElementById("newClientForm").style.display = "block";
            document.getElementById("selectClientForm").style.display = "none";
        }

        function showSelectClientForm() {
            document.getElementById("newClientForm").style.display = "none";
            document.getElementById("selectClientForm").style.display = "block";
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
    </script>
</body>
</html>
