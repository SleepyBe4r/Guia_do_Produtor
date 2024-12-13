<?php    
$scriptPath = "/Guia_do_Produtor/assets/php/conexao.php";
$fullPath = $_SERVER['DOCUMENT_ROOT'] . $scriptPath;
require_once($fullPath);

// Inicializar valores e mensagens
$Tipo = $_POST["tipo"] ?? '';
$Nome = $_POST["nome"] ?? '';
$Ano = $_POST["ano"] ?? '';
$mensagemErro = '';

if (empty($Tipo)) {
    $mensagemErro = "O campo 'Tipo' é obrigatório.";
} elseif (empty($Nome)) {
    $mensagemErro = "O campo 'Nome' é obrigatório.";
} elseif (empty($Ano)) {
    $mensagemErro = "O campo 'Ano do Projeto' é obrigatório.";
} elseif ($Ano < 1999 || $Ano > date('Y')) {
    $mensagemErro = "O ano deve estar entre 1999 e o ano atual.";
}

// Verificar se houve erro nos campos
if ($mensagemErro) {
    // Redirecionar para o formulário com os valores e mensagem
    header("Location: ../../pages/equipe_dashboard/equipe_Index.php?" . http_build_query([
        'erro' => $mensagemErro,
        'tipo' => $Tipo,
        'nome' => $Nome,
        'ano' => $Ano,
    ]));
    exit;
}

// Verificar se uma imagem foi enviada
$destino_BD = '/assets/images/equipe/0.jpg'; // Caminho padrão
if (isset($_FILES['imagem']['name']) && $_FILES['imagem']['error'] == 0) {
    $arquivo_tmp = $_FILES['imagem']['tmp_name'];
    $nome = $_FILES['imagem']['name'];
    $extensao = strtolower(strrchr($nome, '.'));

    if (strstr('.jpg;.jpeg;.gif;.png', $extensao)) {
        $novoNome = md5(microtime()) . $extensao;
        $destino = '../../images/equipe/' . $novoNome;
        if (@move_uploaded_file($arquivo_tmp, $destino)) {
            $destino_BD = '/assets/images/equipe/' . $novoNome;
        }
    }
}

// Inserir dados no banco de dados
try {
    $comando = $conexao->prepare("INSERT INTO `equipe`(`Tipo`, `Nome`, `Ano`, `Imagem_Tipo`) VALUES (:Tipo, :Nome, :Ano, :Imagem_Tipo)");
    $comando->execute([
        ":Tipo" => $Tipo,
        ":Nome" => $Nome,
        ":Ano" => $Ano,
        ":Imagem_Tipo" => $destino_BD,
    ]);

    header("Location: ../../pages/equipe_dashboard/equipe_Index.php?success=1");
    exit;
} catch (PDOException $ex) {
    $mensagemErro = "Erro ao salvar no banco de dados: " . $ex->getMessage();
    header("Location: ../../pages/equipe_dashboard/equipe_Index.php?" . http_build_query([
        'erro' => $mensagemErro,
        'tipo' => $Tipo,
        'nome' => $Nome,
        'ano' => $Ano,
    ]));
    exit;
}
?>
