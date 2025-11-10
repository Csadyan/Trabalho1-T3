<?php
require '../config/conexao.php';

include 'auth_vendedor.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: produto_listar.php");
    exit;
}

try {

    $sql = "DELETE FROM produtos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    
    header("Location: produto_listar.php?status=deletado");
    exit;

} catch (PDOException $e) {
    die("Erro ao deletar produto: " . $e->getMessage());
}
?>