<?php
require '../config/conexao.php';
include '../includes/header.php';

include 'auth_vendedor.php';

$erro = '';
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: produto_listar.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty($_POST['nome']) || empty($_POST['preco'])) {
        $erro = "Nome e Preço são campos obrigatórios.";
    } else {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];

        try {
            $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $descricao, $preco, $id]);
            
            header("Location: produto_listar.php?status=sucesso");
            exit;

        } catch (PDOException $e) {
            $erro = "Erro ao atualizar produto: " . $e->getMessage();
        }
    }
}

try {
    $sql = "SELECT * FROM produtos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produto) {
        header("Location: produto_listar.php");
        exit;
    }
} catch (PDOException $e) {
    die("Erro ao buscar produto: " . $e->getMessage());
}

?>

<h2>Editar Produto (ID: <?php echo $produto['id']; ?>)</h2>
<hr>

<?php if ($erro): ?>
    <div class="alert alert-danger"><?php echo $erro; ?></div>
<?php endif; ?>

<form action="produto_editar.php?id=<?php echo $produto['id']; ?>" method="POST">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome do Produto</label>
        <input type="text" class="form-control" id="nome" name="nome" 
               value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="preco" class="form-label">Preço (Ex: 19.99)</label>
        <input type="number" step="0.01" class="form-control" id="preco" name="preco" 
               value="<?php echo htmlspecialchars($produto['preco']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="3"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
    </div>
    
    <a href="produto_listar.php" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Atualizar Produto</button>
</form>

<?php
include '../includes/footer.php';
?>