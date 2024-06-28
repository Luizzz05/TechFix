<?php include_once 'menu.html'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cliente</title>
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
                <label for="telefone">Telefone:</label>
                <input type="tel" class="form-control" id="telefone" name="telefone" required>
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf" required>
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
                <label for="tipo">Tipo:</label>
                <input type="text" class="form-control" id="tipo" name="tipo" required>
                <label for="marca">Marca:</label>
                <input type="text" class="form-control" id="marca" name="marca" required>
                <label for="modelo">Modelo:</label>
                <input type="text" class="form-control" id="modelo" name="modelo" required>
                <label for="numero_serie">Número de Série:</label>
                <input type="text" class="form-control" id="numero_serie" name="numero_serie" required>
            </div>
            <button type="submit" class="btn btn-success">Cadastrar Aparelho</button>
            <button type="button" class="btn btn-secondary" onclick="showSelectClientForm()">Cancelar</button>
        </form>

        <!-- Formulário para Cadastro de Serviço -->
        <form id="servicoForm" style="display: none;" method="POST" class="mt-3">
            <h2>Cadastro de Serviço</h2>
            <input type="hidden" id="fk_aparelho_id" name="fk_aparelho_id">
            <div class="form-group">
                <label for="descricao">Serviço:</label>
                <textarea class="form-control" id="descricao" name="descricao" required style="resize: none;"></textarea>
                <label for="data_entrada">Data de Entrada:</label>
                <input type="date" class="form-control" id="data_entrada" name="data_entrada" required>
                <label for="fk_complexidade_id">Complexidade:</label>
                <select class="form-control" id="fk_complexidade_id" name="fk_complexidade_id" required onchange="calculateDataPrevista()">
                    <option value="" disabled selected>Selecione a Complexidade</option>
                    <?php
                    $complexidades = mysqli_query($conn, "SELECT complexidade, prazos_dias FROM prazos");
                    while ($complexidade = mysqli_fetch_assoc($complexidades)) {
                        echo "<option value='{$complexidade['complexidade']}'>{$complexidade['complexidade']}</option>";
                    }
                    ?>
                </select>
                <label for="data_prevista">Data Prevista:</label>
                <input type="date" class="form-control" id="data_prevista" name="data_prevista" required readonly>
                <label for="fk_categoria_id">Categoria:</label>
                <select class="form-control" id="fk_categoria_id" name="fk_categoria_id" required>
                <option value="" disabled selected>Selecione a Categoria</option>
                    <?php
                    $categorias = mysqli_query($conn, "SELECT nome, descricao FROM categoria");
                    while ($categoria = mysqli_fetch_assoc($categorias)) {
                        echo "<option value='{$categoria['nome']}'>{$categoria['nome']}</option>";
                    }
                    ?>
                </select>
                <label for="fk_usuarios_id">Usuário Responsável:</label>
                <select class="form-control" id="fk_usuarios_id" name="fk_usuarios_id" required>
                <option value="" disabled selected>Selecione a Categoria</option>
                <?php
                    $usuarios = mysqli_query($conn, "SELECT nome, tipo FROM categoria");
                    while ($usuario = mysqli_fetch_assoc($usuarios)) {
                        echo "<option value='{$usuario['nome, tipo']}'>{$usuario['nome, tipo']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Cadastrar Serviço</button>
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
            document.getElementById("servicoForm").style.display = "none";
        }

        function showServicoForm() {
            document.getElementById("aparelhoForm").style.display = "none";
            document.getElementById("servicoForm").style.display = "block";
        }

        // Função para calcular a data prevista com base na complexidade selecionada
        function calculateDataPrevista() {
            var complexidade = document.getElementById("fk_complexidade_id").value;
            var dataEntrada = new Date(document.getElementById("data_entrada").value);
            var diasAdicionar = 0;

            switch (complexidade) {
                case "1":
                    diasAdicionar = 2;
                    break;
                case "2":
                    diasAdicionar = 4;
                    break;
                case "3":
                    diasAdicionar = 7;
                    break;
                case "4":
                    diasAdicionar = 10;
                    break;
                case "5":
                    diasAdicionar = 14;
                    break;
                default:
                    diasAdicionar = 0;
            }

            var dataPrevista = new Date(dataEntrada);
            dataPrevista.setDate(dataEntrada.getDate() + diasAdicionar);

            var dataPrevistaInput = document.getElementById("data_prevista");
            dataPrevistaInput.value = dataPrevista.toISOString().split('T')[0];
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
                  var aparelhoId = result.aparelho_id; // Supondo que o ID do aparelho é retornado no resultado
                  document.getElementById("fk_aparelho_id").value = aparelhoId;
                  showServicoForm();
              }).catch(error => {
                  console.error('Erro:', error);
                  alert('Ocorreu um erro ao cadastrar o aparelho.');
              });
        });

        // Interceptar o envio do formulário de novo serviço
        document.getElementById("servicoForm").addEventListener("submit", function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch("../controls/cadastrarServico.php", {
                method: "POST",
                body: formData
            }).then(response => response.text())
              .then(result => {
                  alert("Serviço cadastrado com sucesso!");
                  showSelectClientForm();
              }).catch(error => {
                  console.error('Erro:', error);
                  alert('Ocorreu um erro ao cadastrar o serviço.');
              });
        });

        // Função para definir a data atual no campo de data de entrada
        function setDataAtual() {
            var dataEntradaInput = document.getElementById("data_entrada");
            var hoje = new Date().toISOString().split('T')[0];
            dataEntradaInput.value = hoje;
        }

        // Chamar a função quando a página for carregada
        document.addEventListener("DOMContentLoaded", function() {
            setDataAtual();
        });
    </script>
</body>
</html>
