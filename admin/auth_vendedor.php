<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'vendedor') {
    header("Location: ../login.php?erro=Acesso negado. Faça login como vendedor.");
    
    exit;
}
?>