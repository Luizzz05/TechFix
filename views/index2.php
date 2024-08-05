<?php
include_once '../models/conexao.php';
include_once 'menu.html';
session_start();

// Define o número de serviços por página
$servicos_por_pagina = 10;

// Obtém a página atual a partir do parâmetro GET (se não estiver definido, usa a página 1)
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $servicos_por_pagina;

// Consulta SQL para obter o número total de serviços
$sql_total = "SELECT COUNT(*) AS total FROM servicos";
$result_total = mysqli_query($conn, $sql_total);
$total_servicos = mysqli_fetch_assoc($result_total)['total'];

// Calcula o número total de páginas
$total_paginas = ceil($total_servicos / $servicos_por_pagina);

// Consulta SQL para obter serviços e status com LIMIT e OFFSET
$sql = "SELECT ser.id_servicos, ser.descricao, ser.data_entrada, ser.data_prevista, ser.data_conclusao, st.descricao AS status_descricao, ap.tipo, ca.nome as nomecat, pr.complexidade, us.nome 
FROM servicos ser 
JOIN status st on st.id_status = ser.fk_status_id 
JOIN aparelhos ap on ap.id_aparelho = ser.fk_aparelho_id 
JOIN categoria ca on ca.id_categoria = ser.fk_categoria_id 
JOIN prazos pr on pr.complexidade = ser.fk_complexidade_id 
JOIN usuarios us on us.id_usuarios = ser.fk_usuarios_id
LIMIT $servicos_por_pagina OFFSET $offset";

$result  = mysqli_query($conn, $sql);
if (!$result) {
    die("error no banco: " . mysqli_error($conn));
}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">Acompanhamento de Serviços</h1>
            <div style="overflow-x:auto;">
                <h2>Serviços Dentro do Prazo</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descrição</th>
                            <th>Entrada</th>
                            <th>Previsão de Entrega</th>
                            <th>Conclusão</th>
                            <th>Status</th>
                            <th>Aparelho</th>
                            <th>Categoria</th>
                            <th>Complexidade</th>
                            <th>Técnico</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $current_date = date('Y-m-d');
                        if (mysqli_num_rows($result) > 0) {
                            while ($linha = mysqli_fetch_assoc($result)) {
                                $data_entrada = date('d/m/Y', strtotime($linha['data_entrada']));
                                $data_prevista = date('d/m/Y', strtotime($linha['data_prevista']));
                                $data_conclusao = !empty($linha['data_conclusao']) ? date('d/m/Y', strtotime($linha['data_conclusao'])) : '';

                                if (strtotime($linha['data_prevista']) >= strtotime($current_date)) {
                                    // Define a classe da linha com base no status
                                    $row_class = '';
                                    switch ($linha['status_descricao']) {
                                        case 'Em aberto':
                                            $row_class = 'status-aberto';
                                            break;
                                        case 'Em processamento':
                                            $row_class = 'status-processo';
                                            break;
                                        case 'Finalizado':
                                            $row_class = 'status-finalizado';
                                            break;
                                    }
                        ?>
                                    <tr class="<?php echo htmlspecialchars($row_class); ?>">
                                        <td><?php echo htmlspecialchars($linha['id_servicos']); ?></td>
                                        <td><?php echo htmlspecialchars($linha['descricao']); ?></td>
                                        <td><?php echo htmlspecialchars($data_entrada); ?></td>
                                        <td><?php echo htmlspecialchars($data_prevista); ?></td>
                                        <td><?php echo htmlspecialchars($data_conclusao); ?></td>
                                        <td><?php echo htmlspecialchars($linha['status_descricao']); ?></td>
                                        <td><?php echo htmlspecialchars($linha['tipo']); ?></td>
                                        <td><?php echo htmlspecialchars($linha['nomecat']); ?></td>
                                        <td><?php echo htmlspecialchars($linha['complexidade']); ?></td>
                                        <td><?php echo htmlspecialchars($linha['nome']); ?></td>
                                        <td></td>
                                    </tr>
                        <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <h2>Serviços Fora do Prazo</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descrição</th>
                            <th>Entrada</th>
                            <th>Previsão de Entrega</th>
                            <th>Conclusão</th>
                            <th>Status</th>
                            <th>Aparelho</th>
                            <th>Categoria</th>
                            <th>Complexidade</th>
                            <th>Técnico</th>
                         
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Reinicia a busca para dividir os serviços fora do prazo
                        mysqli_data_seek($result, 0);
                        if (mysqli_num_rows($result) > 0) {
                            while ($linha = mysqli_fetch_assoc($result)) {
                                $data_entrada = date('d/m/Y', strtotime($linha['data_entrada']));
                                $data_prevista = date('d/m/Y', strtotime($linha['data_prevista']));
                                $data_conclusao = !empty($linha['data_conclusao']) ? date('d/m/Y', strtotime($linha['data_conclusao'])) : '';

                                if (strtotime($linha['data_prevista']) < strtotime($current_date)) {
                                    // Define a classe da linha com base no status
                                    $row_class = '';
                                    switch ($linha['status_descricao']) {
                                        case 'Em aberto':
                                            $row_class = 'status-aberto';
                                            break;
                                        case 'Em processamento':
                                            $row_class = 'status-processo';
                                            break;
                                        case 'Finalizado':
                                            $row_class = 'status-finalizado';
                                            break;
                                    }
                        ?>
                                    <tr class="<?php echo htmlspecialchars($row_class); ?>">
                                        <td><?php echo htmlspecialchars($linha['id_servicos']); ?></td>
                                        <td><?php echo htmlspecialchars($linha['descricao']); ?></td>
                                        <td><?php echo htmlspecialchars($data_entrada); ?></td>
                                        <td><?php echo htmlspecialchars($data_prevista); ?></td>
                                        <td><?php echo htmlspecialchars($data_conclusao); ?></td>
                                        <td><?php echo htmlspecialchars($linha['status_descricao']); ?></td>
                                        <td><?php echo htmlspecialchars($linha['tipo']); ?></td>
                                        <td><?php echo htmlspecialchars($linha['nomecat']); ?></td>
                                        <td><?php echo htmlspecialchars($linha['complexidade']); ?></td>
                                        <td><?php echo htmlspecialchars($linha['nome']); ?></td>
                                        <td></td>
                                    </tr>
                        <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <nav aria-label="Navegação de página exemplo">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if($pagina_atual <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?pagina=<?php echo $pagina_atual - 1; ?>" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for($i = 1; $i <= $total_paginas; $i++): ?>
                        <li class="page-item <?php if($pagina_atual == $i) echo 'active'; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if($pagina_atual >= $total_paginas) echo 'disabled'; ?>">
                        <a class="page-link" href="?pagina=<?php echo $pagina_atual + 1; ?>" aria-label="Próximo">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Adicionar Novo Serviço</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="serviceForm" action="../controls/cadastrarServicos.php" method="POST">
                                <input type="hidden" id="id_servicos" name="id_servicos">
                                <input type="hidden" id="action" name="action" value="add">
                                <div class="mb-3">
                                    <label for="descricao" class="form-label">Descrição</label>
                                    <input type="text" class="form-control" id="descricao" name="descricao" required>
                                </div>
                                <div class="mb-3">
                                    <label for="data_entrada" class="form-label">Data de Entrada</label>
                                    <input type="date" class="form-control" id="data_entrada" name="data_entrada" required>
                                </div>
                                <div class="mb-3">
                                    <label for="data_prevista" class="form-label">Previsão de Entrega</label>
                                    <input type="date" class="form-control" id="data_prevista" name="data_prevista" required>
                                </div>
                                <div class="mb-3">
                                    <label for="data_conclusao" class="form-label">Data de Conclusão</label>
                                    <input type="date" class="form-control" id="data_conclusao" name="data_conclusao">
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Em aberto">Em aberto</option>
                                        <option value="Em processamento">Em processamento</option>
                                        <option value="Finalizado">Finalizado</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="fk_aparelho_id" class="form-label">Aparelho:</label>
                                    <select class="form-select" id="fk_aparelho_id" name="fk_aparelho_id" required>
                                        <?php
                                        $aparelhos = mysqli_query($conn, "SELECT id_aparelho, tipo, modelo FROM aparelhos");
                                        while ($aparelho = mysqli_fetch_assoc($aparelhos)) {
                                            echo "<option value='{$aparelho['id_aparelho']}'>{$aparelho['tipo']} - {$aparelho['modelo']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="fk_categoria_id">Categoria:</label>
                                    <select class="form-control" id="fk_categoria_id" name="fk_categoria_id" required>
                                        <?php
                                        $categorias = mysqli_query($conn, "SELECT id_categoria, nome, descricao FROM categoria");
                                        while ($categoria = mysqli_fetch_assoc($categorias)) {
                                            echo "<option value='{$categoria['id_categoria']}'>{$categoria['nome']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="fk_complexidade_id">Complexidade:</label>
                                    <select class="form-control" id="fk_complexidade_id" name="fk_complexidade_id" required onchange="calculateDataPrevista()">
                                        <?php
                                        $complexidades = mysqli_query($conn, "SELECT complexidade, complexidade, prazos_dias FROM prazos");
                                        while ($complexidade = mysqli_fetch_assoc($complexidades)) {
                                            echo "<option value='{$complexidade['complexidade']}'>{$complexidade['complexidade']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="fk_usuarios_id">Usuário Responsável:</label>
                                    <select class="form-control" id="fk_usuarios_id" name="fk_usuarios_id" required>
                                        <?php
                                        $usuarios = mysqli_query($conn, "SELECT id_usuarios, nome, tipo FROM usuarios");
                                        while ($usuario = mysqli_fetch_assoc($usuarios)) {
                                            echo "<option value='{$usuario['id_usuarios']}'>{$usuario['nome']} - {$usuario['tipo']}</option>";
                                        }
                                        ?>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="scripts.js"></script>
</body>

</html>
