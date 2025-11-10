<?php
require '../config/conexao.php';
include '../includes/header.php';

include 'auth_vendedor.php';


$mensagem = '';
if (isset($_GET['status']) && $_GET['status'] == 'sucesso') {
    $mensagem = '<div class="alert alert-success">Produto salvo com sucesso!</div>';
}
if (isset($_GET['status']) && $_GET['status'] == 'deletado') {
    $mensagem = '<div class="alert alert-success">Produto deletado com sucesso!</div>';
}

try {
    $sql = "SELECT * FROM produtos ORDER BY nome ASC";
    $stmt = $pdo->query($sql);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro ao listar produtos: " . $e->getMessage();
    $produtos = [];
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Gerenciamento de Produtos</h2>
    <a href="produto_criar.php" class="btn btn-primary">Adicionar Novo Produto</a>
</div>

<?php echo $mensagem;  ?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Descrição</th>
            <th width="150px">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($produtos) > 0): ?>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?php echo $produto['id']; ?></td>
                    <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                    <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($produto['descricao']); ?></td>
                    <td>
                        <a href="produto_editar.php?id=<?php echo $produto['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                        
                        <a href="produto_deletar.php?id=<?php echo $produto['id']; ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Tem certeza que deseja deletar este produto?');">
                           Deletar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Nenhum produto cadastrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


<?php
include '../includes/footer.php';
?>