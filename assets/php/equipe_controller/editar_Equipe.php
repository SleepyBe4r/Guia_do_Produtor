<?php    
    // Caminho do script
    $scriptPath = "/Guia_do_Produtor/assets/php/conexao.php";
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $scriptPath;
    require_once($fullPath);  
    header("Access-Control-Allow-Origin: *"); 

    $ID = $_GET["id_equipe"] ?? null;
    $Tipo = $_POST["tipo"] ?? null;
    $Nome = $_POST["nome"] ?? null;
    $Ano = $_POST["ano"] ?? null;
    $imagem_antiga = $_POST["imagem_antiga"] ?? null;
    $destino_BD = $imagem_antiga;

    $mensagemErro = "";
    $erro = false;

    // Processar imagem se houver upload
    if (isset($_FILES['imagem_nova']) && $_FILES['imagem_nova']['error'] == 0) {
        $imagemNova = $_FILES['imagem_nova'];
        $extensao = strtolower(pathinfo($imagemNova['name'], PATHINFO_EXTENSION));

        if (strstr('.jpg;.jpeg;.gif;.png', $extensao)) {
            $destino = "../../images/equipe/$ID.$extensao";
            if (move_uploaded_file($imagemNova['tmp_name'], $destino)) {
                $destino_BD = "/assets/images/equipe/$ID.$extensao";
            } else {
                $mensagemErro = "Erro ao salvar a imagem. Verifique as permissões.";
                $erro = true;
            }
        } else {
            $mensagemErro = "Formato de imagem inválido. Apenas .jpg, .jpeg, .gif e .png são permitidos.";
            $erro = true;
        }
    }

    // Apenas atualiza no banco se não houver erro de validação
    if (!$erro) {
        try {
            $comando = $conexao->prepare("UPDATE `equipe` SET `Tipo`=:Tipo, `Nome`=:Nome, `Ano`=:Ano, `Imagem_Tipo`=:Imagem_Tipo WHERE `ID` = :ID"); 
            $parametros = [":ID" => $ID, ":Tipo" => $Tipo, ":Nome" => $Nome, ":Ano" => $Ano, ":Imagem_Tipo" => $destino_BD];
            $comando->execute($parametros);

            if ($comando->rowCount() > 0) {
                header("Location: ../../pages/equipe_dashboard/equipe_Index.php");
                exit();
            } else {
                $mensagemErro = "Nenhuma alteração foi feita.";
            }
        } catch (PDOException $ex) {
            $mensagemErro = "Erro ao atualizar a equipe: " . $ex->getMessage();
        }
    }

    // Se houver erro, redireciona para o formulário com os valores anteriores
    header("Location: ../../pages/equipe_dashboard/equipe_Editar.php?id_equipe=$ID&erro=" . urlencode($mensagemErro) . "&tipo=$Tipo&nome=$Nome&ano=$Ano&imagem_antiga=$imagem_antiga");
    exit();
?>
