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

    $comando = $conexao->prepare("SELECT 
                                    p.ID AS Produtor_ID,
                                    p.Nome AS Produtor_Nome,
                                    p.Descricao AS Produtor_Descricao,
                                    p.Data_De_Cadastro AS Produtor_Data_De_Cadastro,
                                    p.Imagem_Tipo AS Produtor_Imagem_Tipo,

                                    GROUP_CONCAT(DISTINCT gp.Grupo) AS Grupo_Produtores_Grupo,
                                    
                                    GROUP_CONCAT(DISTINCT prod.Nome) AS Produtos_Nome,

                                    GROUP_CONCAT(DISTINCT CONCAT_WS(', ', e.Bairro, e.Rua, e.Numero, e.Complemento, ci.Nome)) AS Enderecos,

                                    GROUP_CONCAT(DISTINCT CONCAT_WS(': ', c.Tipo, c.Texto)) AS Contatos

                                FROM 
                                    produtores p

                                LEFT JOIN grupos_produtores gp ON p.ID = gp.ID_Produtores
                                LEFT JOIN produtos_produtores pp ON p.ID = pp.ID_Produtores
                                LEFT JOIN produtos prod ON pp.ID_Produtos = prod.ID
                                LEFT JOIN enderecos e ON p.ID = e.ID_Produtores
                                LEFT JOIN cidades ci ON e.ID_Cidades = ci.ID
                                LEFT JOIN contatos c ON p.ID = c.ID_Produtores

                                GROUP BY 
                                    p.ID
                                ORDER BY
                                    gp.Grupo;
                                "); 
        
    $comando->execute(); 
    $count = $comando->rowCount();
    

    while($linha = $comando->fetch(PDO::FETCH_OBJ))        
    {  
        $pasta = '../images/plantacao/';
        $nomeImagem = $linha->Produtor_ID . "_";
        $padrao = $pasta . "*" . $nomeImagem . "*.{jpg,jpeg,png,gif}";
        $imagens = glob($padrao, GLOB_BRACE);
        if (count($imagens) > 0) { $imagenRand = $imagens[array_rand($imagens)]; }
        else { $imagenRand = $linha->Produtor_Imagem_Tipo; }

        switch ($linha->Grupo_Produtores_Grupo) {
            case 1:                
                $cor = "bg-custom-3";                
                $strTipo = "<p class='card-text'>Grupo: Vegetais</p>";                
                break;
            case 2:           
                $cor = "bg-custom-1";
                $strTipo = "<p class='card-text'>Grupo: Frutas</p>";                
                break;
            case 3:            
                $cor = "bg-custom-2";
                $strTipo = "<p class='card-text'>Grupo: Proteina</p>";                
                break;
            case 4:            
                $cor = "bg-custom-5";
                $strTipo = "<p class='card-text'>Grupo: Laticinios</p>";                
                break;
            case 5:            
                $cor = "bg-custom-4";
                $strTipo = "<p class='card-text'>Grupo: Processados</p>";                
                break;
            default:
                $cor = "";
                $strTipo = "<p class='card-text'>Grupo: Nenhum</p>";                
                break;
        }        
            
        print("                      
            <div class=' col-md-4 col-sm-6 col-12 mb-3'>
                <div class='card " . $cor ."'>
                    <img style=' height:300px; object-fit: cover' src='". ($linha->Produtor_Imagem_Tipo == "/assets/images/produtores/0.jpg"? $imagenRand : "../../" . $linha->Produtor_Imagem_Tipo) ."' class='card-img-top' alt='Imagem 1'>
                    <div class='card-body'>
                        <h5 class='card-title'>". $linha->Produtor_Nome ."</h5>
                        ". $strTipo ."
                        <button class='btn btn-custom-1 btn-block' onclick='ver_Mais(". $linha->Produtor_ID .")' >Ver mais</button>
                        
                    </div>
                </div>
            </div>     
        ");               
        
    }
        
     
        
    
    

?>