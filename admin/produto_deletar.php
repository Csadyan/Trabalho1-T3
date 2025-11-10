<?php
require '../config/conexao.php';

include 'auth_vendedor.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: produto_listar.php");
    exit;
}

try {
    // 3. Lógica de Deleção (Delete)
    // Segurança: Prepared statements contra SQL Injection [cite: 27]
    $sql = "DELETE FROM produtos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    
    // Redireciona para a listagem com msg de sucesso
    header("Location: produto_listar.php?status=deletado");
    exit;

} catch (PDOException $e) {
    // Tratar erro (ex: se o produto estiver em um carrinho, pode dar erro de FK)
    // No nosso caso (ON DELETE CASCADE) não dará erro, mas é bom saber.
    die("Erro ao deletar produto: " . $e->getMessage());
}
?>