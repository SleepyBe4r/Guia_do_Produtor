<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Destruir a sessão
    session_unset(); // Remove todas as variáveis de sessão
    session_destroy(); // Destrói a sessão

    // Redirecionar para a página de login ou inicial
    header("Location: ../../pages/Login.php");
    exit;
?>
