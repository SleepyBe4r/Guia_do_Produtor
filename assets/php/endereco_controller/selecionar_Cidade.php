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

    //Definir o criterio de pesquisa (Where);
    
    if(isset($_GET["ID_UF"]))
    { 
        $UF = $_GET["ID_UF"];        
    }
            
    //Preparar o comando sql para enviar ao banco de dados;
    $comando = $conexao->prepare("SELECT * FROM `cidades` WHERE ID_UF = :ID_UF ");
      
    //Execultar o comando preparado no banco de dados;

    $parametros = [":ID_UF" => $UF,];

    $comando->execute($parametros); 
    
    $return = array();

    while($linha = $comando->fetch(PDO::FETCH_OBJ))        
    {        
        $return[] = array("ID"=> $linha->ID, "Nome"=>$linha->Nome);
    };            
    
    echo json_encode($return);
?>