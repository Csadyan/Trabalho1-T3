<?php
require 'config/conexao.php';
include 'includes/header.php';

try {
    $sql = "SELECT * FROM produtos ORDER BY nome ASC";
    $stmt = $pdo->query($sql);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro ao listar produtos: " . $e->getMessage();
    $produtos = []; 
}
?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Nossos Produtos</h2>
    </div>
</div>

<div class="row">
    <?php if (count($produtos) > 0): ?>
        <?php foreach ($produtos as $produto): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($produto['nome']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                        <h4 class="card-text text-success">
                            R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                        </h4>
                    </div>
                    <div class="card-footer">
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'cliente'): ?>
                            <a href="carrinho_acoes.php?acao=add&id=<?php echo $produto['id']; ?>" class="btn btn-primary w-100">
                                Adicionar ao Carrinho
                            </a>
                        <?php elseif (!isset($_SESSION['user_id'])): ?>
                             <a href="login.php" class="btn btn-secondary w-100">Faça login para comprar</a>
                        <?php endif; ?>
                        </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <p class="alert alert-warning">Nenhum produto cadastrado no momento.</p>
        </div>
    <?php endif; ?>
</div>

<?php

include 'includes/footer.php';
?>