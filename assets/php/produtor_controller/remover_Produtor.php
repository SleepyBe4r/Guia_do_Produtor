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
    $ID = $_GET["ID_Produtor"];       
    
    //Produtos do Produtor
    $comando = $conexao ->prepare("DELETE FROM `produtos_produtores` WHERE `ID_Produtores` = :ID");
    //Bindar/Juntar os parametros;   
    $parametros = [":ID" => $ID];
    try { $comando->execute($parametros); }
    catch (PDOException $ex) { echo (json_encode($ex)); }
    
    //Grupo do produtor 
    $comando = $conexao ->prepare("DELETE FROM `grupos_produtores` WHERE `ID_Produtores` = :ID");
    //Bindar/Juntar os parametros;   
    $parametros = [":ID" => $ID];
    try { $comando->execute($parametros); }
    catch (PDOException $ex) { echo (json_encode($ex)); }

    //Contato     
    $comando = $conexao ->prepare("DELETE FROM `contatos` WHERE `ID_Produtores` = :ID");
    //Bindar/Juntar os parametros;   
    $parametros = [":ID" => $ID];
    try { $comando->execute($parametros); }
    catch (PDOException $ex) { echo (json_encode($ex)); }
    
    //Endereço
    $comando = $conexao ->prepare("DELETE FROM `enderecos` WHERE `ID_Produtores` = :ID");
    //Bindar/Juntar os parametros;       
    $parametros = [":ID" => $ID];
    try { $comando->execute($parametros); }
    catch (PDOException $ex) { echo (json_encode($ex)); }
    
    //Produtor
    $comando = $conexao ->prepare("DELETE FROM `produtores` WHERE `ID` = :ID");    
    //Bindar/Juntar os parametros;   
    $parametros = [":ID" => $ID];
    try { $comando->execute($parametros); echo (json_encode("success"));  }
    catch (PDOException $ex) { echo (json_encode($ex)); }
    
?>