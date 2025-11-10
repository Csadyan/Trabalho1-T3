<?php
session_start(); 

require 'config/conexao.php';
$erro = '';
$mensagem_sucesso = '';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['status']) && $_GET['status'] == 'registrado') {
    $mensagem_sucesso = "Cadastro realizado com sucesso! Faça seu login.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty($_POST['email']) || empty($_POST['senha'])) {
        $erro = "E-mail e senha são obrigatórios.";
    } else {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        try {
            $sql = "SELECT * FROM usuarios WHERE email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_nome'] = $usuario['nome'];
                $_SESSION['user_type'] = $usuario['tipo'];
                
                header("Location: index.php");
                exit;
            } else {
                $erro = "E-mail ou senha inválidos.";
            }

        } catch (PDOException $e) {
            $erro = "Erro no login: " . $e->getMessage();
        }
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <h2 class="text-center">Login</h2>
        <hr>

        <?php if ($erro): ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php endif; ?>

        <?php if ($mensagem_sucesso): ?>
            <div class="alert alert-success"><?php echo $mensagem_sucesso; ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Entrar</button>
        </form>
        <p class="text-center mt-3">
            Não tem uma conta? <a href="registrar.php">Registre-se aqui</a>.
        </p>
    </div>
</div>

<?php
include 'includes/footer.php';
?>