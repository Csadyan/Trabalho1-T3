<?php
require '../config/conexao.php';
include '../includes/header.php';

include 'auth_vendedor.php';

$erro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['nome']) || empty($_POST['preco'])) {
        $erro = "Nome e Preço são campos obrigatórios.";
    } else {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];

        try {
            $sql = "INSERT INTO produtos (nome, descricao, preco) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $descricao, $preco]);
            
            header("Location: produto_listar.php?status=sucesso");
            exit;

        } catch (PDOException $e) {
            $erro = "Erro ao salvar produto: " . $e->getMessage();
        }
    }
}
?>

<h2>Adicionar Novo Produto</h2>
<hr>

<?php if ($erro): ?>
    <div class="alert alert-danger"><?php echo $erro; ?></div>
<?php endif; ?>

<form action="produto_criar.php" method="POST">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome do Produto</label>
        <input type="text" class="form-control" id="nome" name="nome" required>
    </div>
    <div class="mb-3">
        <label for="preco" class="form-label">Preço (Ex: 19.99)</label>
        <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
    </div>
    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
    </div>
    
    <a href="produto_listar.php" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Salvar Produto</button>
</form>

<?php
include '../includes/footer.php';
?>