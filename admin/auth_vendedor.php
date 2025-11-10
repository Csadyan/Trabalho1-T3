<?php
// Garante que a sessão seja iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Se a sessão não existir, ou o user_id não estiver definido, 
// ou o tipo não for 'vendedor', ele é expulso.

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'vendedor') {
    // Redireciona para a página de login (que está um nível acima)
    header("Location: ../login.php?erro=Acesso negado. Faça login como vendedor.");
    
    // Garante que o script pare de ser executado
    exit;
}
?>