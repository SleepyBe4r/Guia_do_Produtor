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

    if(isset($_GET["id_produto"]))
    { 
        $ID = $_GET["id_produto"];        
    }

    if(isset($_POST["grupo"]))
    { 
        $Grupo = $_POST["grupo"];        
    }

    if(isset($_POST["nome"]))
    { 
        $Nome = $_POST["nome"];        
    }    

    $comando = $conexao->prepare("SELECT * FROM `produtos` WHERE `Nome` = :Nome AND `ID` != :ID;"); 

    $Nome = strtolower($Nome);
    
    $parametros = [":Nome" => $Nome,
                   ":ID" => $ID,];

    try
    {
        //Execultar o comando preparado no banco de dados;
        $comando->execute($parametros);     
        //Preparando o retorno para o fetch;
        $count = $comando->rowCount();                        

        if ($count != 0) {            
            print("
            <script>                
                window.location.href='../../pages/produto_dashboard/produto_Edit.php';
            </script>
        "); 
        }
    }
    catch (PDOException $ex)
    {      
        echo (json_encode($ex));          
    }
        	
    //Preparar o comando sql para enviar ao banco de dados;  
    $comando = $conexao->prepare("UPDATE `produtos` SET `Nome`=:Nome,`ID_Grupo`=:ID_Grupo WHERE `ID` = :ID"); 
    
    //Bindar/Juntar os parametros;  
    $parametros = [":ID" => $ID,
                   ":ID_Grupo" => $ID_Grupo,
                   ":Nome" => $Nome];
        
    try
    {
        //Execultar o comando preparado no banco de dados;
        $comando->execute($parametros);                
        //Preparando o retorno para o fetch;
        $count = $comando->rowCount();                        

        if ($count != 0) {
            print("
                <script>                
                    window.location.href='../../pages/produto_dashboard/produto_Index.php';
                </script>
            ");                
        }
    }
    catch (PDOException $ex)
    {      
        echo (json_encode($ex));  
        /*print("
            <script>
                alert('Não foi possível incluir o telefone. Verifique!');
                window.location.href='../../index.php';
            </script>
        ");*/
    }

?>