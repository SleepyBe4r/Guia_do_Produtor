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

    // Produtor
    if(isset($_POST["nome"])) $Nome = $_POST["nome"]; else return;
    if(isset($_POST["descricao"])) $Descricao = $_POST["descricao"]; else return;
  
    //Endereço
    if(isset($_POST["cidade"])) $Cidade = $_POST["cidade"]; else return;
    if(isset($_POST["cep"])) $CEP = $_POST["cep"];
    if(isset($_POST["bairro"])) $Bairro = $_POST["bairro"]; else return;
    if(isset($_POST["rua"])) $Rua = $_POST["rua"]; else return;
    if(isset($_POST["numero"])) $Numero = $_POST["numero"]; else return;
    if(isset($_POST["complemento"])) $Complemento = $_POST["complemento"];

    //Contato     
	if(isset($_POST["tipo"])) $Tipo = $_POST["tipo"]; else return;
    if(isset($_POST["texto"])) $Texto = $_POST["texto"]; else return;

    //Grupo do produtor
    if(isset($_POST["grupo"])) $Grupo = $_POST["grupo"]; else return;

    
    //Produtos do Produtor
    if(isset($_POST["produto"])) $Produto = $_POST["produto"]; else return;
    
    
    
    $comando = $conexao->prepare("SELECT * FROM `produtores` ORDER BY `ID` DESC LIMIT 1"); 
    $comando->execute(); 
    $linha = $comando->fetch(PDO::FETCH_OBJ);
    
    $Last_ID = $linha->ID + 1;    
    
    if ( isset( $_FILES[ 'imagem' ][ 'name' ] ) && $_FILES[ 'imagem' ][ 'error' ] == 0 ) {
        $arquivo_tmp = $_FILES['imagem']['tmp_name'];
        $nome = $_FILES['imagem']['name'];
        
        // Pega a extensao
        $extensao = strrchr($nome, '.');

        // Converte a extensao para mimusculo
        $extensao = strtolower($extensao);

        // Somente imagens, .jpg;.jpeg;.gif;.png
        // Aqui eu enfilero as extesões permitidas e separo por ';'
        // Isso server apenas para eu poder pesquisar dentro desta String
        if(strstr('.jpg;.jpeg;.gif;.png', $extensao))
        {
            // Cria um nome único para esta imagem
            // Evita que duplique as imagens no servidor.
            $novoNome = md5(microtime()) . '.' . $extensao;
            
            // Concatena a pasta com o nome            
            $destino = '../../images/produtores/' . $novoNome; 
            $destino_BD = '/assets/images/produtores/' . $Last_ID . $extensao; 
            
            // tenta mover o arquivo para o destino
            if( @move_uploaded_file( $arquivo_tmp, $destino  ))
            {
                rename($destino,"../../images/produtores/" . $Last_ID . $extensao);
            }
            else
                echo "Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />";
        }
    } else{
        $destino_BD = '/assets/images/produtores/0.jpg'; 
    }    
	
    //Preparar o comando sql para enviar ao banco de dados;  
    $comando = $conexao->prepare("INSERT INTO `produtores`(`Nome`, `Descricao`, `Data_De_Cadastro`, `Imagem_Tipo`)
                                  VALUES (:Nome, :Descricao, CURDATE(), :Imagem_Tipo)");
    
    //Bindar/Juntar os parametros;   
    $parametros = [":Nome" => $Nome,
                   ":Descricao" => $Descricao,
                   ":Imagem_Tipo" => $destino_BD];
    
    try
    {
        //Execultar o comando preparado no banco de dados;
        $comando->execute($parametros);        
        $Last_ID_P = $conexao->lastInsertId();
        //Preparando o retorno para o fetch;
        $count = $comando->rowCount();                        

        if ($count == 0) {
            print("
                <script>                
                    window.location.href='../../pages/produtor_dashboard/produtor_Create.php';
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

    if(isset($_FILES[ 'plantacao' ][ 'name' ])) $Plantacao = $_FILES[ 'plantacao' ][ 'name' ]; else return;

    for ($i=0; $i < count($Plantacao); $i++) {         
        
            $arquivo_tmp = $_FILES['plantacao']['tmp_name'];
            $nome = $_FILES['plantacao']['name'];

            // Pega a extensao
            $extensao = strrchr($nome[$i], '.');
    
            // Converte a extensao para mimusculo
            $extensao = strtolower($extensao);
    
            // Somente imagens, .jpg;.jpeg;.gif;.png
            // Aqui eu enfilero as extesões permitidas e separo por ';'
            // Isso server apenas para eu poder pesquisar dentro desta String
            

            if(strstr('.jpg;.jpeg;.gif;.png', $extensao))
            {
                // Cria um nome único para esta imagem
                // Evita que duplique as imagens no servidor.
                $novoNome = md5(microtime()) . '.' . $extensao;
                
                // Concatena a pasta com o nome            
                $destino = '../../images/produtores/' . $novoNome;                 
                
                // tenta mover o arquivo para o destino                
                if( @move_uploaded_file( $arquivo_tmp[$i], $destino  ))
                {                    
                    rename($destino,"../../images/plantacao/" . $Last_ID_P . "_" . ($i + 1) . $extensao);
                }
                else
                    echo "Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />";
            }
        
    }

    //Endereço
    for ($i=0; $i < count($Cidade); $i++) {  
        //Preparar o comando sql para enviar ao banco de dados;   
        $comando = $conexao ->prepare("INSERT INTO `enderecos`(`ID_Produtores`, `ID_Cidades`, `CEP`, `Bairro`, `Rua`, `Numero`, `Complemento`)
                                            VALUES (:ID_Produtores, :ID_Cidades, :CEP, :Bairro, :Rua, :Numero, :Complemento)");
        
        //Bindar/Juntar os parametros;   
        $parametros = [":ID_Produtores" => $Last_ID_P,
                       ":ID_Cidades" => $Cidade[$i],
                       ":CEP" => $CEP[$i],
                       ":Bairro" => $Bairro[$i],
                       ":Rua" => $Rua[$i],
                       ":Numero" => $Numero[$i],
                       ":Complemento" => $Complemento[$i]];

        try
        {
            //Execultar o comando preparado no banco de dados;
            $comando->execute($parametros);        
            $Last_ID = $conexao->lastInsertId();
            //Preparando o retorno para o fetch;
            $count = $comando->rowCount();                        
    
            if ($count == 0) {
                print("
                    <script>                
                        window.location.href='../../pages/produtor_dashboard/produtor_Create.php';
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
    }

    //Contato     
    for ($i=0; $i < count($Tipo); $i++) { 
        //Preparar o comando sql para enviar ao banco de dados;  
        $comando = $conexao->prepare("INSERT INTO `contatos`(`ID_Produtores`, `Tipo`, `Texto`)
                                      VALUES (:ID_Produtores, :Tipo, :Texto)");
        
        //Bindar/Juntar os parametros;   
        $parametros = [":ID_Produtores" => $Last_ID_P,
                       ":Tipo" => $Tipo[$i],
                       ":Texto" => $Texto[$i]];
        
        try
        {
            //Execultar o comando preparado no banco de dados;
            $comando->execute($parametros);        
            $Last_ID = $conexao->lastInsertId();
            //Preparando o retorno para o fetch;
            $count = $comando->rowCount();                        
    
            if ($count == 0) {
                print("
                    <script>                
                        window.location.href='../../pages/produtor_dashboard/produtor_Create.php';
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
    }

    //Grupo do produtor        
    for ($i=0; $i < count($Grupo); $i++) { 
        //Preparar o comando sql para enviar ao banco de dados;  
        $comando = $conexao->prepare("INSERT INTO `grupos_produtores`(`Grupo`, `ID_Produtores`)
                                      VALUES (:Grupo, :ID_Produtores)");
        
        //Bindar/Juntar os parametros;   
        $parametros = [":Grupo" => $Grupo[$i],
                       ":ID_Produtores" => $Last_ID_P];
        
        try
        {
            //Execultar o comando preparado no banco de dados;
            $comando->execute($parametros);        
            $Last_ID = $conexao->lastInsertId();
            //Preparando o retorno para o fetch;
            $count = $comando->rowCount(); 
            if ($count == 0) {
                print("
                    <script>                
                        window.location.href='../../pages/produtor_dashboard/produtor_Create.php';
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

        //Produtos do Produtor
        for ($j=0; $j < count($Produto); $j++) {
            
            $comando = $conexao->prepare("SELECT * FROM `produtos` WHERE ID_Grupo = :ID_Grupo");
            
            //Bindar/Juntar os parametros;   
            $parametros = [":ID_Grupo" => $Grupo[$i]];

            $comando->execute($parametros);       
            
            while ($linha = $comando->fetch(PDO::FETCH_OBJ)) {

                if($linha->ID == $Produto[$j]){
                    //Preparar o comando sql para enviar ao banco de dados;  
                    $comando = $conexao->prepare("INSERT INTO `produtos_produtores`(`ID_Produtores`, `ID_Grupos_Produtores`, `ID_Produtos`)
                                                VALUES (:ID_Produtores, :ID_Grupos_Produtores, :ID_Produtos)");
                    
                    //Bindar/Juntar os parametros;   
                    $parametros = [":ID_Produtores" => $Last_ID_P,
                                ":ID_Grupos_Produtores" => $Last_ID,
                                ":ID_Produtos" => $Produto[$j]];
                    
                    try
                    {
                        //Execultar o comando preparado no banco de dados;
                        $comando->execute($parametros);     
                        //Preparando o retorno para o fetch;
                        $count = $comando->rowCount();                        
                
                        if ($count == 0) {
                            print("
                                <script>                
                                    window.location.href='../../pages/produtor_dashboard/produtor_Create.php';
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
                }                
            }
        }
    }

    print("
        <script>                
            window.location.href='../../pages/produtor_dashboard/produtor_Index.php';
        </script>
    ");   
    
?>