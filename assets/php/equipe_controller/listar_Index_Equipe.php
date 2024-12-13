<?php
    // Caminho do script, você pode definir conforme necessário
    if (session_status() == PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['localhost'])) $scriptPath = "/Guia_do_Produtor/assets/php/conexao.php";
    else $scriptPath = "/assets/php/conexao.php";

    // Caminho absoluto usando DOCUMENT_ROOT
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $scriptPath;

    // Inclui o arquivo PHP com o caminho absoluto
    require_once($fullPath);  
    
    //Preparar o comando sql para enviar ao banco de dados;
    $comando = $conexao->prepare("SELECT * FROM `equipe` WHERE Ano = :Ano"); 
      
    //Execultar o comando preparado no banco de dados;
    $AnoAtual = date('Y'); 
    $AnoAtual = intval($AnoAtual);
    $parametros = [":Ano" => $AnoAtual,];
    
    $comando->execute($parametros); 
    print(" <div id='carrosel_Prof' class='row p-2 h-75' 
            style='flex-wrap: nowrap; overflow: hidden;'>");     
    
    while($linha = $comando->fetch(PDO::FETCH_OBJ))        
    {
                
        if ($linha->Tipo == "P"){
             print("                      
                <div class='card col-7 col-sm-6 col-md-5 col-lg-4 col-xl-3 shadow m-2 p-4' style='aspect-ratio: 3 / 4;'>
                    <img style=' object-fit: cover; border-radius: 10px' src='." . $linha->Imagem_Tipo . "' class='card-img-top h-75' draggable='false'>
                    <div class='card-body h-25'>
                        <h5 class='card-title'>". $linha->Nome ."</h5>                       
                    </div>
                </div>

            ");
        } 
        

    };            
    
    print("</div>");

    print(" <div id='carrosel_Alunos' class='row p-2 h-75' 
             style='flex-wrap: nowrap; overflow: hidden; dyplay: none;'>");     

             $comando->execute($parametros); 
    while($linha = $comando->fetch(PDO::FETCH_OBJ))        
    {
        
        if ($linha->Tipo == "A"){
            print("                      
                <div class='card col-7 col-sm-6 col-md-5 col-lg-4 col-xl-3 shadow m-2 p-4' style='aspect-ratio: 3 / 4;'>
                    <img style=' object-fit: cover; border-radius: 10px' src='." . $linha->Imagem_Tipo . "' class='card-img-top h-75' draggable='false'>
                    <div class='card-body h-25'>
                        <h5 class='card-title'>". $linha->Nome ."</h5>                       
                    </div>
                </div>

            ");
        } 
        

    };             
    
    print("</div>");

?>