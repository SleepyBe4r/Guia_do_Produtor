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
    
    $ID = $_GET["ID_Equipe"];        
    
    //Preparar o comando sql para enviar ao banco de dados;  
    $comando = $conexao->prepare("DELETE FROM `equipe` WHERE `ID` = :ID");
    

    //Bindar/Juntar os parametros;   
    $parametros = [":ID" => $ID];
    
    try
    {
        //Execultar o comando preparado no banco de dados;
        $comando->execute($parametros);                      
                
        echo (json_encode("success"));                      
    }
    catch (PDOException $ex)
    {      
        echo (json_encode($ex));  
    }

?>