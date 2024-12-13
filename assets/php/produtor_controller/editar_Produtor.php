<?php
    // Caminho do script, você pode definir conforme necessário
    if (session_status() == PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['localhost'])) $scriptPath = "/Guia_do_Produtor/assets/php/conexao.php";
    else $scriptPath = "/assets/php/conexao.php";
        
    // Caminho absoluto usando DOCUMENT_ROOT
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $scriptPath;

    // Inclui o arquivo PHP com o caminho absoluto
    require_once($fullPath);  

    header("Access-Control-Allow-Origin: *"); 
    function executarSQL($conexao, $sql, $parametros) {
        try {
            $comando = $conexao->prepare($sql);
            $comando->execute($parametros);
            return $comando;
        } catch (PDOException $ex) {
            error_log("Erro SQL: " . $ex->getMessage());
            echo json_encode(["erro" => $ex->getMessage()]);
            return null;
        }
    }

    function moverArquivo($arquivoTmp, $destinoFinal) {
        if (move_uploaded_file($arquivoTmp, $destinoFinal)) {
            return true;
        } else {
            error_log("Erro ao mover arquivo para $destinoFinal");
            return false;
        }
    }

    // Validação dos parâmetros principais
    $ID_P = isset($_GET["id_produtor"]) ? (int)$_GET["id_produtor"] : null;
    if (!$ID_P) {
        echo json_encode(["erro" => "ID do produtor é obrigatório"]);
        exit;
    }

    // Dados principais
    $Nome = $_POST["nome"] ?? null;
    $Descricao = $_POST["descricao"] ?? null;
    $imagem_antiga = $_POST["imagem_antiga"] ?? null;
    // Processamento de Imagens
    if (isset($_FILES['imagem_nova'])) {
        $imagemNova = $_FILES['imagem_nova'];
        $extensao = strtolower(pathinfo($imagemNova['name'], PATHINFO_EXTENSION));
        $destino = "../../images/produtores/" . $ID_P . ".$extensao";

        if (strstr('.jpg;.jpeg;.gif;.png', $extensao)) {
            if (moverArquivo($imagemNova['tmp_name'], $destino)) {
                $destino_BD = "/assets/images/produtores/" . $ID_P . ".$extensao";
            }
        }
    } else {
        $destino_BD = $imagem_antiga;
    }

    // Atualização do produtor
    $sqlUpdateProdutor = "UPDATE `produtores` 
                        SET `Nome` = :Nome, `Descricao` = :Descricao, `Imagem_Tipo` = :Imagem_Tipo 
                        WHERE `ID` = :ID";
    executarSQL($conexao, $sqlUpdateProdutor, [
        ":ID" => $ID_P,
        ":Nome" => $Nome,
        ":Descricao" => $Descricao,
        ":Imagem_Tipo" => $destino_BD ?? null
    ]);

    // Limpeza e Reinsersão de dados relacionados
    $deleteTables = [
        "enderecos" => "DELETE FROM `enderecos` WHERE `ID_Produtores` = :ID",
        "contatos" => "DELETE FROM `contatos` WHERE `ID_Produtores` = :ID",
        "grupos_produtores" => "DELETE FROM `grupos_produtores` WHERE `ID_Produtores` = :ID",
        "produtos_produtores" => "DELETE FROM `produtos_produtores` WHERE `ID_Produtores` = :ID"
    ];

    foreach ($deleteTables as $tabela => $query) {
        executarSQL($conexao, $query, [":ID" => $ID_P]);
    }

    // Inserção de Endereços
    if (!empty($_POST["cidade"])) {
        foreach ($_POST["cidade"] as $index => $cidade) {
            executarSQL($conexao, "INSERT INTO `enderecos`(`ID_Produtores`, `ID_Cidades`, `CEP`, `Bairro`, `Rua`, `Numero`, `Complemento`)
                                VALUES (:ID_Produtores, :ID_Cidades, :CEP, :Bairro, :Rua, :Numero, :Complemento)", [
                ":ID_Produtores" => $ID_P,
                ":ID_Cidades" => $cidade,
                ":CEP" => $_POST["cep"][$index] ?? null,
                ":Bairro" => $_POST["bairro"][$index] ?? null,
                ":Rua" => $_POST["rua"][$index] ?? null,
                ":Numero" => $_POST["numero"][$index] ?? null,
                ":Complemento" => $_POST["complemento"][$index] ?? null
            ]);
        }
    }

    // Inserção de Contatos
    if (!empty($_POST["tipo"])) {
        foreach ($_POST["tipo"] as $index => $tipo) {
            executarSQL($conexao, "INSERT INTO `contatos`(`ID_Produtores`, `Tipo`, `Texto`)
                                VALUES (:ID_Produtores, :Tipo, :Texto)", [
                ":ID_Produtores" => $ID_P,
                ":Tipo" => $tipo,
                ":Texto" => $_POST["texto"][$index]
            ]);
        }
    }

    // Inserção de Grupos e Produtos
    if (!empty($_POST["grupo"])) {
        foreach ($_POST["grupo"] as $grupo) {
            $comando = executarSQL($conexao, "INSERT INTO `grupos_produtores`(`Grupo`, `ID_Produtores`)
                                            VALUES (:Grupo, :ID_Produtores)", [
                ":Grupo" => $grupo,
                ":ID_Produtores" => $ID_P
            ]);
            $Last_ID = $conexao->lastInsertId();


            // Associar Produtos
            if (!empty($_POST["produto"])) {
                foreach ($_POST["produto"] as $produto) {
                    executarSQL($conexao, "INSERT INTO `produtos_produtores`(`ID_Produtores`, `ID_Grupos_Produtores`, `ID_Produtos`)
                                        VALUES (:ID_Produtores, :ID_Grupos_Produtores, :ID_Produtos)", [
                        ":ID_Produtores" => $ID_P,
                        ":ID_Grupos_Produtores" => $Last_ID,
                        ":ID_Produtos" => $produto
                    ]);
                }
            }
        }
    }

    // Redirecionamento final
    header("Location: ../../pages/produtor_dashboard/produtor_Index.php");
    exit();
?>
