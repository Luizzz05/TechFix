<?php include_once 'menu.html'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body class="bg-light text-dark">
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Selecione ou Cadastre um Cliente</h1>
        
        
        <!-- Formulário para Selecionar Cliente -->
        <form id="selectClientForm" class="form-container">
            <div class="mb-3">
                <label for="clients" class="form-label">Selecione um Cliente:</label>
                <select id="clients" name="clients" class="form-select" onchange="checkClient()">
                    <option value="" disabled selected>Escolha um cliente</option>
                    <?php
                    include_once '../models/conexao.php';
                    if ($conn) {
                        $result = mysqli_query($conn, "SELECT id_clientes, nome FROM clientes");
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='{$row['id_clientes']}'>{$row['nome']}</option>";
                        }
                    } else {
                        echo "<option value='' disabled>Erro na conexão com o banco de dados</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-primary" onclick="submitClientForm()">Continuar</button>
                <button type="button" class="btn btn-secondary" onclick="showNewClientForm()">Novo Cliente</button>
            </div>
        </form>
        
        <!-- Formulário para Cadastro de Novo Cliente -->
        <form id="newClientForm" style="display: none;" method="POST" class="form-container mt-4">
            <h2 class="mb-3 text-center">Cadastro de Novo Cliente</h2>
            <input type="hidden" name="action" value="add">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone:</label>
                <input type="tel" class="form-control" id="telefone" name="telefone" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="cpf" class="form-label">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf" required>
            </div>
            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço:</label>
                <input type="text" class="form-control" id="endereco" name="endereco" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Cadastrar</button>
                <button type="button" class="btn btn-secondary" onclick="showSelectClientForm()">Cancelar</button>
            </div>
        </form>

        <!-- Formulário para Cadastro de Aparelho -->
        <form id="aparelhoForm" style="display: none;" method="POST" class="form-container mt-4">
            <h2 class="mb-3 text-center">Cadastro de Aparelho</h2>
            <input type="hidden" id="fk_clientes_id" name="fk_clientes_id">
            <div class="mb-3">
                <label for="clientName" class="form-label">Cliente:</label>
                <input type="text" class="form-control" id="clientName" name="clientName" readonly>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo:</label>
                <input type="text" class="form-control" id="tipo" name="tipo" required>
            </div>
            <div class="mb-3">
                <label for="marca" class="form-label">Marca:</label>
                <input type="text" class="form-control" id="marca" name="marca" required>
            </div>
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo:</label>
                <input type="text" class="form-control" id="modelo" name="modelo" required>
            </div>
            <div class="mb-3">
                <label for="numero_serie" class="form-label">Número de Série:</label>
                <input type="text" class="form-control" id="numero_serie" name="numero_serie" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Cadastrar Aparelho</button>
                <button type="button" class="btn btn-secondary" onclick="showSelectClientForm()">Cancelar</button>
            </div>
        </form>
        
        <!-- Formulário para Cadastro de Serviço -->
        <form id="servicoForm" style="display: none;" action="../controls/cadastrarServicos.php" method="POST" class="form-container mt-4">
            <h2 class="mb-3 text-center">Cadastro de Serviço</h2>
            <div class="mb-3">
                <label for="fk_aparelho_id" class="form-label">Aparelho:</label>
                <select class="form-select" id="fk_aparelho_id" name="fk_aparelho_id" required>
                    <option value="" disabled selected>Selecione o aparelho</option>
                    <?php
                    $aparelhos = mysqli_query($conn, "SELECT id_aparelho, tipo, modelo FROM aparelhos");
                    while ($aparelho = mysqli_fetch_assoc($aparelhos)) {
                        echo "<option value='{$aparelho['id_aparelho']}'>{$aparelho['tipo']} - {$aparelho['modelo']}</option>";
                    }
                    ?>
                </select>
                
                <label for="descricao">Serviço:</label>
                <textarea class="form-control" id="descricao" name="descricao" required style="resize: none;"></textarea>
                
                <label for="data_entrada">Data de Entrada:</label>
                <input type="date" class="form-control" id="data_entrada" name="data_entrada" required readonly>
                
                <label for="fk_complexidade_id">Complexidade:</label>
                <select class="form-control" id="fk_complexidade_id" name="fk_complexidade_id" required onchange="calculateDataPrevista()">
                    <option value="" disabled selected>Selecione a Complexidade</option>
                    <?php
                    $complexidades = mysqli_query($conn, "SELECT complexidade, complexidade, prazos_dias FROM prazos");
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
                    $categorias = mysqli_query($conn, "SELECT id_categoria, nome, descricao FROM categoria");
                    while ($categoria = mysqli_fetch_assoc($categorias)) {
                        echo "<option value='{$categoria['id_categoria']}'>{$categoria['nome']}</option>";
                    }
                    ?>
                </select>
                
                <label for="fk_usuarios_id">Usuário Responsável:</label>
                <select class="form-control" id="fk_usuarios_id" name="fk_usuarios_id" required>
                    <option value="" disabled selected>Selecione o Usuário</option>
                    <?php
                    $usuarios = mysqli_query($conn, "SELECT id_usuarios, nome, tipo FROM usuarios");
                    while ($usuario = mysqli_fetch_assoc($usuarios)) {
                        echo "<option value='{$usuario['id_usuarios']}'>{$usuario['nome']} - {$usuario['tipo']}</option>";
                    }
                    ?>
                </select>
                
                <label for="fk_status_id">Status:</label>
                <select class="form-control" id="fk_status_id" name="fk_status_id" required disabled>
                    <?php
                    $stats = mysqli_query($conn, "SELECT id_status, descricao FROM status WHERE id_status = 1");
                    $status = mysqli_fetch_assoc($stats);
                    echo "<option value='{$status['id_status']}' selected>{$status['descricao']}</option>";
                    ?>
                </select>
                <input type="hidden" name="fk_status_id" value="1">
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Cadastrar Serviço</button>
                <button type="button" class="btn btn-secondary" onclick="showSelectClientForm()">Cancelar</button>
            </div>
        </form>
        <!-- Barra de Progresso -->
        <div class="progress-container mb-4">
            <ul class="progressbar">
                <li class="active" id="step1">Seleção de Cliente</li>
                <li id="step2">Cadastro de Cliente</li>
                <li id="step3">Cadastro de Aparelho</li>
                <li id="step4">Cadastro de Serviço</li>
            </ul>
        </div>
    </div>
    
    <script src="scripts.js"></script>
</body>
</html>
