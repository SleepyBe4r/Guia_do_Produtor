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
            
    //Preparar o comando sql para enviar ao banco de dados;
    $comando = $conexao->prepare("SELECT * FROM `equipe`"); 
      
    //Execultar o comando preparado no banco de dados;

    
    $comando->execute(); 

    print("
        <table class='table table-striped'>
            <thead>
                <tr>
                    <th class='d-none d-lg-table-cell'>ID</th>
                    <th class='d-none d-md-table-cell'>Nome</th>
                    <th class='d-none d-lg-table-cell'>Tipo</th>                
                    <th class='d-none d-xl-table-cell'>Ano</th>  
                    <th class='d-none d-xl-table-cell'>Imagem</th>  
                    <th class='d-none d-md-table-cell'>Ações</th>
                </tr>
    ");     

    while($linha = $comando->fetch(PDO::FETCH_OBJ))        
    {

        if ($linha->Tipo == "A"){
            $strTipo = "<td class='d-none d-lg-table-cell'>Aluno</td>";
        } 
        else if ($linha->Tipo == "P") 
        {
            $strTipo = "<td class='d-none d-lg-table-cell'>Professor</td>";
        }

        print("        
            <tr id='" . $linha->ID ."'>               
                <td class='d-none d-lg-table-cell'>" . $linha->ID . "</td>
                <td class='d-none d-md-table-cell'>" . $linha->Nome . "</td>
                " . $strTipo ."
                <td class='d-none d-xl-table-cell'>" . $linha->Ano . "</td>                

                <td class='d-none d-xl-table-cell'> <img  src= '../../" . $linha->Imagem_Tipo . "' height='200' /> </td>        
                <td class='d-none d-md-table-cell'> 
                    <button class='btn btn-danger' onclick='remover_Equipe(this.parentNode.parentNode.id)'>Remover Membro</button> 
                    <button class='btn btn-primary m-1' onclick='editar_Equipe(this.parentNode.parentNode.id)'>Editar Membro</button> 
                </td>
                
            </tr>                            
        ");
    };            
    
    print("</tbody></table>");

?>