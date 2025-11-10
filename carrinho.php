<?php
// 1. Conexão e Header
require 'config/conexao.php';
include 'includes/header.php';

// Proteção: Somente clientes podem ver o carrinho
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'cliente') {
    header("Location: login.php?erro=Faça login como cliente.");
    exit;
}

$id_usuario = $_SESSION['user_id'];
$mensagem = ''; // Mensagem de sucesso foi removida, pois agora vamos direto ao PDF

// 2. Lógica de Listagem (Read)
try {
    $sql = "SELECT 
                p.id, 
                p.nome, 
                p.preco, 
                c.id_produto,
                c.quantidade 
            FROM carrinho c
            JOIN produtos p ON c.id_produto = p.id
            WHERE c.id_usuario = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_usuario]);
    $itens_carrinho = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro ao listar produtos: " . $e->getMessage();
    $itens_carrinho = [];
}

$total_carrinho = 0;
?>

<h2>Meu Carrinho de Compras</h2>
<hr>

<?php if (count($itens_carrinho) > 0): ?>
    
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Produto</th>
                <th>Preço Unitário</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itens_carrinho as $item): ?>
                <?php
                    $subtotal = $item['preco'] * $item['quantidade'];
                    $total_carrinho += $subtotal;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['nome']); ?></td>
                    <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo $item['quantidade']; ?></td>
                    <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                    <td>
                        <a href="carrinho_acoes.php?acao=remover&id=<?php echo $item['id_produto']; ?>" class="btn btn-sm btn-danger">
                            Remover
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="table-light">
                <td colspan="3" class="text-end"><strong>TOTAL:</strong></td>
                <td colspan="2">
                    <h4 class="text-success m-0">
                        R$ <?php echo number_format($total_carrinho, 2, ',', '.'); ?>
                    </h4>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="text-end">
        <a href="recibo_pdf.php" class="btn btn-lg btn-success" target="_blank">
           Finalizar Compra e Gerar Recibo
        </a>
        <p class="mt-2"><small>(Seu recibo abrirá em uma nova aba e seu carrinho será esvaziado)</small></p>
    </div>

<?php else: ?>
    <div class="alert alert-info">Seu carrinho está vazio.</div>
    <a href="index.php" class="btn btn-primary">Ver produtos</a>
<?php endif; ?>

<?php
// 4. Footer
include 'includes/footer.php';
?>