<?php
require 'config/conexao.php';
session_start();

// Proteção: Somente clientes podem mexer no carrinho
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'cliente') {
    header("Location: login.php?erro=Faça login como cliente.");
    exit;
}

$id_usuario = $_SESSION['user_id'];
$acao = $_GET['acao'] ?? 'ver'; // Ação padrão
$id_produto = $_GET['id'] ?? null;

try {
    if ($acao == 'add' && $id_produto) {
        // Ação: Adicionar ao Carrinho
        $sql = "SELECT * FROM carrinho WHERE id_usuario = ? AND id_produto = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_usuario, $id_produto]);
        $item = $stmt->fetch();

        if ($item) {
            $sql_update = "UPDATE carrinho SET quantidade = quantidade + 1 WHERE id = ?";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute([$item['id']]);
        } else {
            $sql_insert = "INSERT INTO carrinho (id_usuario, id_produto, quantidade) VALUES (?, ?, 1)";
            $stmt_insert = $pdo->prepare($sql_insert);
            $stmt_insert->execute([$id_usuario, $id_produto]);
        }
        header("Location: index.php"); // Redireciona de volta para a loja
        exit;
    }

    if ($acao == 'remover' && $id_produto) {
        // Ação: Remover item específico
        // [MUDANÇA AQUI] Corrigido para id_produto, para corresponder ao carrinho.php
        $sql = "DELETE FROM carrinho WHERE id_usuario = ? AND id_produto = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_usuario, $id_produto]);
        
        header("Location: carrinho.php"); // Volta para o carrinho
        exit;
    }

    // Ação 'finalizar' foi REMOVIDA daqui.

} catch (PDOException $e) {
    die("Erro na ação do carrinho: " . $e->getMessage());
}

// Se nenhuma ação for reconhecida, apenas volta ao carrinho
header("Location: carrinho.php");
exit;
?>