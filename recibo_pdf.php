<?php
require 'config/conexao.php';
require 'fpdf/fpdf.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'cliente') {
    die("Acesso negado. Faça login como cliente.");
}
$id_usuario = $_SESSION['user_id'];
$nome_usuario = $_SESSION['user_nome'];

try {
    $sql = "SELECT p.nome, p.preco, c.quantidade 
            FROM carrinho c
            JOIN produtos p ON c.id_produto = p.id
            WHERE c.id_usuario = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_usuario]);
    $itens_carrinho = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (!$itens_carrinho) {
        die("Seu carrinho está vazio.");
    }

} catch (PDOException $e) {
    die("Erro ao buscar itens: " . $e->getMessage());
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(190, 10, 'Recibo da Compra', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, 'Cliente: ' . $nome_usuario, 0, 1, 'L');
$pdf->Cell(190, 10, 'Data: ' . date('d/m/Y H:i:s'), 0, 1, 'L');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, 'Produto', 1, 0, 'L');
$pdf->Cell(30, 10, 'Qtd.', 1, 0, 'C');
$pdf->Cell(30, 10, 'Preco Unit.', 1, 0, 'R');
$pdf->Cell(30, 10, 'Subtotal', 1, 1, 'R');

$pdf->SetFont('Arial', '', 12);
$total_compra = 0;
foreach ($itens_carrinho as $item) {
    $subtotal = $item['preco'] * $item['quantidade'];
    $total_compra += $subtotal;
    
    $pdf->Cell(100, 10, $item['nome'], 1, 0, 'L');
    $pdf->Cell(30, 10, $item['quantidade'], 1, 0, 'C');
    $pdf->Cell(30, 10, number_format($item['preco'], 2, ',', '.'), 1, 0, 'R');
    $pdf->Cell(30, 10, number_format($subtotal, 2, ',', '.'), 1, 1, 'R');
}

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(160, 10, 'TOTAL DA COMPRA:', 1, 0, 'R');
$pdf->Cell(30, 10, 'R$ ' . number_format($total_compra, 2, ',', '.'), 1, 1, 'R');

try {
    $sql_delete = "DELETE FROM carrinho WHERE id_usuario = ?";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->execute([$id_usuario]);
} catch (PDOException $e) {
    error_log("Erro ao limpar carrinho do usuario $id_usuario: " . $e->getMessage());
}

$pdf->Output('I', 'recibo_' . date('Y-m-d') . '.pdf');
?>