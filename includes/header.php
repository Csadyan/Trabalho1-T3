<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$BASE_PATH = "/T3 Trabalho-1"; 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Vendas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="<?php echo $BASE_PATH; ?>/index.php">Minha Loja</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="container text-center">
                <div class="row">
                    <div class="col">
                        <li class="bl3 nav-item">
                            <span class="navbar-text text-white me-3">
                                Bem vindo, <?php echo htmlspecialchars($_SESSION['user_nome']); ?>
                            </span>
                        </li>
                    </div>    
                    <div class="col">
                        <?php if ($_SESSION['user_type'] == 'vendedor'): ?>
                            <li class="nav-item">
                                <a class="btn btn-primary w-100" href="<?php echo $BASE_PATH; ?>/admin/produto_listar.php">Administração</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="btn btn-primary w-100" href="<?php echo $BASE_PATH; ?>/carrinho.php">Consultar Carrinho</a>
                            </li>
                        <?php endif; ?>
                    </div>
                    <div class="col">
                        <li class="nav-item">
                            <a class="btn btn-warning w-100" href="<?php echo $BASE_PATH; ?>/logout.php">Logout</a>
                        </li>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $BASE_PATH; ?>/login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $BASE_PATH; ?>/registrar.php">Registrar</a>
            </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>

<div class="container">