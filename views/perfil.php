<?php
include_once 'menu.html';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['nome_de_usuario'])) {
    header("Location: login.php"); // Redireciona para a página de login se não estiver logado
    exit();
}

include_once '../models/conexao.php';

$nome_de_usuario = $_SESSION['nome_de_usuario'];

// Recupera os dados do usuário do banco de dados
$sql = "SELECT * FROM usuarios WHERE nome_de_usuario = '$nome_de_usuario'";
$resultado = mysqli_query($conn, $sql);

if ($resultado && mysqli_num_rows($resultado) > 0) {
    $usuario = mysqli_fetch_assoc($resultado);
    $nome = $usuario['nome'];
    $email = $usuario['email'];
    $telefone = $usuario['telefone'];
    $cargo = $usuario['tipo'];
    // Senha não deve ser exibida
} else {
    // Caso o usuário não seja encontrado
    $nome = 'Nome não definido';
    $email = 'Email não definido';
    $telefone = 'Telefone não definido';
    $cargo = 'Cargo não definido';
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .password-container {
            position: relative;
        }
        .password-container input[type="password"],
        .password-container input[type="text"] {
            width: 100%;
            padding-right: 40px; /* Espaço para o ícone */
        }
        .password-container .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
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
                    <form method="POST" action="../controls/atualizarPerfil.php">
                        <!-- Form Group (nome)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="nome">Nome</label>
                            <input class="form-control" id="nome" name="nome" type="text" value="<?php echo htmlspecialchars($nome); ?>">
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (nome de usuário)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="nome_de_usuario">Nome de Usuário</label>
                                <input class="form-control" id="nome_de_usuario" name="nome_de_usuario" type="text" value="<?php echo htmlspecialchars($nome_de_usuario); ?>" disabled>
                            </div>
                            <!-- Form Group (cargo)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="tipo">Cargo</label>
                                <input class="form-control" id="tipo" name="tipo" type="text" value="<?php echo htmlspecialchars($cargo); ?>" disabled>
                            </div>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (telefone)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="telefone">Número de Telefone</label>
                                <input class="form-control" id="telefone" name="telefone" type="tel" value="<?php echo htmlspecialchars($telefone); ?>">
                            </div>
                            <!-- Form Group (email)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="email">Email</label>
                                <input class="form-control" id="email" name="email" type="email" value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                        </div>
                        <!-- Form Group (senha)-->
                        <div class="mb-3 password-container">
                            <label class="small mb-1" for="senha">Senha</label>
                            <input class="form-control" id="senha" name="senha" type="password" placeholder="Digite uma nova senha">
                            <i class="fas fa-eye toggle-password" style="padding: 26px 0 0 0;" onclick="togglePasswordVisibility()"></i>
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="submit">Salvar alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="scripts.js"></script>
</body>
</html>
