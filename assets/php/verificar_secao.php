<?php
// Inicia a sessão
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    // Redireciona para a página de login se não estiver logado
    header("Location: login.php");
    exit;
}

// Exibe conteúdo restrito para usuários logados
echo "Bem-vindo, " . $_SESSION['username'] . "!";
?>
