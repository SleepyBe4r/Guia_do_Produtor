<?php
    // Caminho do script, você pode definir conforme necessário
    if (session_status() == PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['localhost'])) $scriptPath = "/Guia_do_Produtor/assets/php/conexao.php";
    else $scriptPath = "/assets/php/conexao.php";
    // Caminho absoluto usando DOCUMENT_ROOT
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $scriptPath;
    
    // Inclui o arquivo PHP com o caminho absoluto
    require_once($fullPath);  
                            

    $Showed = 1;

    for ($i=1; $i <= 5; $i++) {                     
        
        $comando = $conexao->prepare("SELECT 
                                        p.ID AS Produtor_ID,
                                        p.Nome AS Produtor_Nome,
                                        p.Descricao AS Produtor_Descricao,
                                        p.Data_De_Cadastro AS Produtor_Data_De_Cadastro,
                                        p.Imagem_Tipo AS Produtor_Imagem_Tipo,

                                        GROUP_CONCAT(DISTINCT gp.Grupo) AS Grupo_Produtores_Grupo,
                                        
                                        GROUP_CONCAT(DISTINCT prod.Nome) AS Produtos_Nome,
                                        
                                        GROUP_CONCAT(DISTINCT CONCAT_WS('|', e.Rua, e.Numero, e.Bairro, e.Complemento, ci.Nome, es.UF)) AS Enderecos,

                                        GROUP_CONCAT(DISTINCT CONCAT_WS(': ', c.Tipo, c.Texto)) AS Contatos

                                    FROM 
                                        produtores p

                                    LEFT JOIN grupos_produtores gp ON p.ID = gp.ID_Produtores
                                    LEFT JOIN produtos_produtores pp ON p.ID = pp.ID_Produtores
                                    LEFT JOIN produtos prod ON pp.ID_Produtos = prod.ID
                                    LEFT JOIN enderecos e ON p.ID = e.ID_Produtores
                                    LEFT JOIN cidades ci ON e.ID_Cidades = ci.ID
                                    LEFT JOIN estados es ON ci.ID_UF = es.ID
                                    LEFT JOIN contatos c ON p.ID = c.ID_Produtores

                                    WHERE 
                                        gp.Grupo = :Grupo

                                    GROUP BY 
                                        p.ID;
                                    "); 
    
        $parametros = [":Grupo" => $i];
        $comando->execute($parametros); 

        $ids = $comando->fetchAll(PDO::FETCH_COLUMN);
        
        if ($ids) {
            // Pick a random ID from the array of IDs
            $randomId = $ids[array_rand($ids)];                
        }            
        
        $comando->execute($parametros); 
        
        while($linha = $comando->fetch(PDO::FETCH_OBJ))        
        {            
            switch ($linha->Grupo_Produtores_Grupo) {
                case 1:
                    $cor = "bg-custom-3";                
                    $strTipo = "<h1>Vegetais</h1>";                
                    break;
                case 2:
                    $cor = "bg-custom-1";
                    $strTipo = "<h1>Frutas</h1>";                
                    break;
                case 3:
                    $cor = "bg-custom-2";
                    $strTipo = "<h1>Proteina</h1>";                
                    break;
                case 4:
                    $cor = "bg-custom-5";
                    $strTipo = "<h1>Laticinios</h1>";                
                    break;
                case 5:
                    $cor = "bg-custom-4";
                    $strTipo = "<h1>Processados</h1>";                
                    break;
                default:
                    $cor = "";
                    $strTipo = "<h1>Nenhum</h1>";                
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


            if ($randomId == $linha->Produtor_ID) {
                $pasta = './assets/images/plantacao/';
                $nomeImagem = $linha->Produtor_ID . "_";
                $padrao = $pasta . "*" . $nomeImagem . "*.{jpg,jpeg,png,gif}";
                $imagens = glob($padrao, GLOB_BRACE);
                if (count($imagens) > 0) { $imagenRand = $imagens[array_rand($imagens)]; }
                else { $imagenRand = $linha->Produtor_Imagem_Tipo; }

                if ($Showed % 2 != 0){
                    echo "       
                        <div class='" . $cor ." my-4 shadow producer-left row ' style='min-height: 250px'>                            
                            <div class='producer-image-div p-4 col-sm-4 '><img class='d-block w-100 img-fluid shadow' src='." . ($linha->Produtor_Imagem_Tipo == "/assets/images/produtores/0.jpg"? $imagenRand :$linha->Produtor_Imagem_Tipo) ."' alt=''></div>
                            <div class='producer-content-div p-4 col-sm-8 d-flex flex-column justify-content-around'>
                                <div class='row'>
                                    " . $strTipo . "
                                </div>
                                <div style='display: inline;' class='row'>
                                    <h4 style='word-break: break-word; white-space: normal;'>Nome: " . $linha->Produtor_Nome . "</h4>
                                    <h4 style='word-break: break-word; white-space: normal;'>Produto(s): " . $linha->Produtos_Nome . "</h4>
                                    <h4 style='word-break: break-word; white-space: normal;'>Endereço: " . $endereco_completo . "</h4>
                                </div>
                                <div class='row'>
                                    <button class='btn btn-custom-1 w-50' onclick='ver_Mais(". $linha->Produtor_ID .")' >Ver mais</button>
                                </div>                        
                            </div>
                        </div>
                    ";
                    $Showed++;
                } else {
                    print("                      
                        <div class='" . $cor ." my-4 producer-right row justify-content-end' style='min-height: 250px'>                            
                            <div class='producer-content-div p-4 col-sm-8 d-flex flex-column justify-content-around text-end'>
                                <div class='row'>
                                    " . $strTipo . "
                                </div>
                                <div class='row'>
                                    <h4 style='word-break: break-word; white-space: normal;'>Nome: " . $linha->Produtor_Nome . "</h4>
                                    <h4 style='word-break: break-word; white-space: normal;'>Produto(s): " . $linha->Produtos_Nome . "</h4>
                                    <h4 style='word-break: break-word; white-space: normal;'>Endereço: " . $endereco_completo . "</h4>
                                </div>                        
                                <div class='row justify-content-end'>
                                    <button class='btn btn-custom-1 w-50' onclick='ver_Mais(". $linha->Produtor_ID .")' >Ver mais</button>
                                </div>                        
                            </div>
                            <div class='producer-image-div p-4 col-sm-4'><img class='d-block w-100 img-fluid shadow' src='." . ($linha->Produtor_Imagem_Tipo == "/assets/images/produtores/0.jpg"? $imagenRand :$linha->Produtor_Imagem_Tipo) ."' alt=''></div>
                        </div>      
                    ");
                    $Showed++;
                }                
            }
        };            
        
    }
    

?>