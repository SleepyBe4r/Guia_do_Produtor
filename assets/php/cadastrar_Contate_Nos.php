<?php    

    require_once("conexao.php");    
            
    header("Access-Control-Allow-Origin: *"); 

    if(isset($_GET["nome"]))
    { 
        $Nome = $_GET["nome"];        
    }

    if(isset($_GET["email"]))
    { 
        $Email = $_GET["email"];        
    }

    if(isset($_GET["mensagem"]))
    { 
        $Mensagem = $_GET["mensagem"];        
    }
    
    $comando = $conexao->prepare("INSERT INTO `pedidos`( `Nome`, `Email`, `Mensagem`) VALUES (:Nome, :Email, :Mensagem)"); 

    //Bindar/Juntar os parametros;   
    $parametros = [":Nome" => $Nome,
                   ":Email" => $Email,
                   ":Mensagem" => $Mensagem];
    
    try
    {
        //Execultar o comando preparado no banco de dados;
        $comando->execute($parametros);        

        echo json_encode(['success' => true]);
        
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