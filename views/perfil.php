<?php
include_once 'menu.html';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['nome_de_usuario'])) {
    header("Location: login.php"); // Redireciona para a página de login se não estiver logado
    exit();
}

// Recupera os dados do usuário da sessão com verificações
$nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Nome não definido';
$nome_de_usuario = isset($_SESSION['nome_de_usuario']) ? $_SESSION['nome_de_usuario'] : 'Usuário não definido';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Email não definido';
$telefone = isset($_SESSION['telefone']) ? $_SESSION['telefone'] : 'Telefone não definido';
$cargo = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : 'Cargo não definido';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container-xl px-4 mt-4">
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile icon-->
                    <i class="fas fa-user-circle fa-7x mb-2"></i>
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">JPG ou PNG no maior que 5 MB</div>
                    <!-- Profile picture upload button-->
                    <button class="btn btn-primary" type="button">Upload nova imagem</button>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Detalhes da Conta</div>
                <div class="card-body">
                    <form>
                        <!-- Form Group (nome)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="nome">Nome</label>
                            <input class="form-control" id="nome" type="text" value="<?php echo htmlspecialchars($nome); ?>">
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (nome de usuário)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="nome_de_usuario">Nome de Usuário</label>
                                <input class="form-control" id="nome_de_usuario" type="text" value="<?php echo htmlspecialchars($nome_de_usuario); ?>">
                            </div>
                            <!-- Form Group (cargo)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="tipo">Cargo</label>
                                <input class="form-control" id="tipo" type="text" value="<?php echo htmlspecialchars($cargo); ?>">
                            </div>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (telefone)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="telefone">Número de Telefone</label>
                                <input class="form-control" id="telefone" type="tel" value="<?php echo htmlspecialchars($telefone); ?>">
                            </div>
                            <!-- Form Group (email)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="email">Email</label>
                                <input class="form-control" id="email" type="email" value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                        </div>
                        <!-- Form Group (senha)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputPassword">Senha</label>
                            <input class="form-control" id="inputPassword" type="password" placeholder="Enter new password">
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="button">Salvar alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
