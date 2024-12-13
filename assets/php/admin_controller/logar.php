<?php
// Configuração de segurança e sessão
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);
session_start();

$scriptPath = "/Guia_do_Produtor/assets/php/conexao.php";
$fullPath = $_SERVER['DOCUMENT_ROOT'] . $scriptPath;
require_once($fullPath);

$Login = $_GET["login"] ?? null;
$Senha = $_GET["senha"] ?? null;
$Confirm_Senha = $_GET["confirma_senha"] ?? null;

function redirectWithError($errorCode, $loginValue, $senhaValue, $confirmaSenhaValue) {
    $url = "../../pages/Login.php?" . http_build_query([
        'erro' => $errorCode,
        'login' => $loginValue,
        'senha' => $senhaValue,
        'confirma_senha' => $confirmaSenhaValue
    ]);
    header("Location: $url");
    exit;
}

// Validação dos campos
if (!$Login) {
    redirectWithError(1, $Login, $Senha, $Confirm_Senha);
}
if (!$Senha) {
    redirectWithError(2, $Login, $Senha, $Confirm_Senha);
}
if (!$Confirm_Senha) {
    redirectWithError(3, $Login, $Senha, $Confirm_Senha);
}
if ($Senha !== $Confirm_Senha) {
    redirectWithError(4, $Login, $Senha, $Confirm_Senha);
}

try {
    $comando = $conexao->prepare("SELECT * FROM `admin` WHERE Login = :Login");
    $comando->execute([":Login" => $Login]);
    $user = $comando->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($Senha, $user['Senha'])) {
        redirectWithError(5, $Login, $Senha, $Confirm_Senha);
    }

    // Login bem-sucedido
    $_SESSION['user_id'] = $user['ID'];
    $_SESSION['username'] = $user['Login'];
    header("Location: ../../pages/dashboard.php");
    exit;
} catch (PDOException $ex) {
    echo "Erro ao acessar o banco de dados: " . $ex->getMessage();
    exit;
}
?>
