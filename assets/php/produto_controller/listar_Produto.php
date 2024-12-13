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
    $comando = $conexao->prepare("SELECT * FROM `produtos`"); 
      
    //Execultar o comando preparado no banco de dados;

    
    $comando->execute(); 

    print("
        <table class='table table-striped'>
            <tr id='0'>
                <th class='d-none d-md-table-cell'>ID</th>
                <th class='d-none d-lg-table-cell'>Nome</th>	               
                <th class='d-none d-xl-table-cell'>Grupos</th>  
                <th class='d-none d-md-table-cell'>Ações</th>
            </tr>
    ");     

    $ID_Anterior = 0;
    while($linha = $comando->fetch(PDO::FETCH_OBJ))        
    {        
        switch ($linha->ID_Grupo) {
            case 1:
                $strTipo = "<td class='d-none d-xl-table-cell'>Vegetais</td>";                
                break;
            case 2:
                $strTipo = "<td class='d-none d-xl-table-cell'>Frutas</td>";                
                break;
            case 3:
                $strTipo = "<td class='d-none d-xl-table-cell'>Proteina</td>";                
                break;
            case 4:
                $strTipo = "<td class='d-none d-xl-table-cell'>Laticinios</td>";                
                break;
            case 5:
                $strTipo = "<td class='d-none d-xl-table-cell'>Processados</td>";                
                break;
            default:
                $strTipo = "<td class='d-none d-xl-table-cell'>Nenhum</td>";                
                break;
        }        
        print("        
            <tr id='" . $linha->ID . "'>                                   
                <td class='d-none d-md-table-cell'>" . $linha->ID . "</td>	                                            
                <td class='d-none d-md-table-cell'>" . $linha->Nome . "</td>	                                            
                " . $strTipo ."           
                <td class='d-none d-md-table-cell'> 
                    <button class='btn btn-danger' onclick='remover_Produto(this.parentNode.parentNode.id)'>Remover Produto</button> 
                    <button class='btn btn-primary m-1' onclick='editar_Produto(this.parentNode.parentNode.id)'>Editar Produto</button> 
                </td>                
            </tr>                            
        ");
                
    };            
    
    print("</table>");

?>