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
    $comando = $conexao->prepare("SELECT p.ID AS Produtor_ID,
                                        p.Nome AS Produtor_Nome,
                                        p.Descricao AS Produtor_Descricao,
                                        p.Data_De_Cadastro AS Produtor_Data_De_Cadastro,
                                        p.Imagem_Tipo AS Produtor_Imagem_Tipo,

                                        GROUP_CONCAT(DISTINCT gp.Grupo) AS Grupo_Produtores_Grupo,
                                        
                                        GROUP_CONCAT(DISTINCT prod.Nome) AS Produtos_Nome,

                                        GROUP_CONCAT(DISTINCT CONCAT_WS('|', e.Rua, e.Numero, e.Bairro, e.Complemento, ci.Nome, es.UF)) AS Enderecos,

                                        GROUP_CONCAT(DISTINCT CONCAT_WS(': ', c.Texto)) AS Contatos

                                    FROM 
                                        produtores p

                                    LEFT JOIN grupos_produtores gp ON p.ID = gp.ID_Produtores
                                    LEFT JOIN produtos_produtores pp ON p.ID = pp.ID_Produtores
                                    LEFT JOIN produtos prod ON pp.ID_Produtos = prod.ID
                                    LEFT JOIN enderecos e ON p.ID = e.ID_Produtores
                                    LEFT JOIN estados es ON ci.ID_UF = es.ID
                                    LEFT JOIN contatos c ON p.ID = c.ID_Produtores

                                    GROUP BY 
                                        p.ID;"); 
      
    //Execultar o comando preparado no banco de dados;

    
    $comando->execute(); 

    print("
        <table class='table table-striped'>
            <tr id='0'>
                <th class='d-none d-md-table-cell'>ID</th>
                <th class='d-none d-md-table-cell'>Nome</th>	
                <th class='d-none d-lg-table-cell'>Descrição</th>          
                <th class='d-none d-xl-table-cell'>Endereços</th>                  
                <th class='d-none d-xl-table-cell'>Contatos</th>
                <th class='d-none d-xl-table-cell'>Grupos</th>  
                <th class='d-none d-md-table-cell'>Ações</th>
            </tr>
    ");     

    $ID_Anterior = 0;
    while($linha = $comando->fetch(PDO::FETCH_OBJ))        
    {        
        switch ($linha->Grupo_Produtores_Grupo) {
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

        $endereco = $linha->Enderecos;
            $array_endereco = explode("|", $endereco);            
            
            // Inicializa uma string para juntar os valores
            $endereco_completo = "";

            // Verifique se o índice existe antes de usar
            $endereco_completo .= (isset($array_endereco[0]) && $array_endereco[0] != "" ? "rua: " . $array_endereco[0] : "");
            $endereco_completo .= (isset($array_endereco[0]) && $array_endereco[0] != "" && 
                                   isset($array_endereco[1]) && $array_endereco[1] != "" ? "," : "");

            $endereco_completo .= (isset($array_endereco[1]) && $array_endereco[1] != "" ? " " . $array_endereco[1] : "");
            $endereco_completo .= (isset($array_endereco[1]) && $array_endereco[1] != "" && 
                                   isset($array_endereco[2]) && $array_endereco[2] != "" ? "-" : "");

            $endereco_completo .= (isset($array_endereco[2]) && $array_endereco[2] != "" ? " " . $array_endereco[2] : "");
            $endereco_completo .= (isset($array_endereco[2]) && $array_endereco[2] != "" && 
                                   isset($array_endereco[3]) && $array_endereco[3] != "" ||
                                   isset($array_endereco[1]) && $array_endereco[1] != "" && 
                                   isset($array_endereco[3]) && $array_endereco[3] != "" ? "," : "");

            $endereco_completo .= (isset($array_endereco[3]) && $array_endereco[3] != "" ? " " . $array_endereco[3] : "");
            $endereco_completo .= (isset($array_endereco[3]) && $array_endereco[3] != "" && 
                                   isset($array_endereco[4]) && $array_endereco[4] != "" ||
                                   isset($array_endereco[2]) && $array_endereco[2] != "" && 
                                   isset($array_endereco[4]) && $array_endereco[4] != "" ? "," : "");

            $endereco_completo .= (isset($array_endereco[4]) && $array_endereco[4] != "" ? " " . $array_endereco[4] : "");
            $endereco_completo .= (isset($array_endereco[4]) && $array_endereco[4] != "" && 
                                   isset($array_endereco[5]) && $array_endereco[5] != "" ? "-" : "");

            $endereco_completo .= (isset($array_endereco[5]) && $array_endereco[5] != "" ? $array_endereco[5] : "");

        print("        
            <tr  id='" . $linha->Produtor_ID ."'>               
                <td class='d-none d-md-table-cell'> <p>" . $linha->Produtor_ID . "</p></td>
                <td class='d-none d-md-table-cell'> <p>" . $linha->Produtor_Nome . "</p></td>	
                <td class='d-none d-lg-table-cell'> <p style='max-height: 250px !important; overflow:auto;'>" . $linha->Produtor_Descricao . "</p></td>	                                                            
                <td class='d-none d-xl-table-cell'> <p>" . $endereco_completo  . "</p></td>                
                <td class='d-none d-xl-table-cell'> <p>" . $linha->Contatos . "</p></td>                
                " . $strTipo ."
                <td class='d-none d-md-table-cell'> 
                    <button class='btn btn-danger m-1' onclick='remover_Produtor(this.parentNode.parentNode.id)'>Remover Produtor</button> 
                    <button class='btn btn-primary m-1' onclick='editar_Produtor(this.parentNode.parentNode.id)'>Editar Produtor</button> 
                </td>                
            </tr>                            
        ");       
    };            
    
    print("</table>");

?>