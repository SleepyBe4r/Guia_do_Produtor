<?php    
    // Caminho do script, você pode definir conforme necessário
    if (session_status() == PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['localhost'])) $scriptPath = "/Guia_do_Produtor/assets/php/conexao.php";
    else $scriptPath = "/assets/php/conexao.php";
    
    // Caminho absoluto usando DOCUMENT_ROOT
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $scriptPath;
    
    // Inclui o arquivo PHP com o caminho absoluto
    require_once($fullPath);  
            

    if(isset($_POST["Cadastrar"]))
    { 
        $UsuarioNome = $_POST["Nome"];
        $usuario = $_POST["Usuario"];
        $usuario = trim($usuario);
        $Senha = $_POST["Senha"];        
        $Senha = trim($Senha);
    }

    $flag = 0;
    $administrador = 0;
    
    //Preparar o comando sql para enviar ao banco de dados;  
    $comando = $conexao->prepare("INSERT INTO usuarios(Usuario, Senha, Administrador, UsuarioNome, Flag)
                                  VALUES (:Usuario, :Senha, :Administrador, :UsuarioNome, :Flag)");
    

    //Bindar/Juntar os parametros;   
    $parametros = [":Usuario" => $usuario,
                   ":Senha" => $Senha,
                   ":Administrador" => $administrador,
                   ":UsuarioNome" => $UsuarioNome,
                   ":Flag" => $flag,];
    
    try
    {
        //Execultar o comando preparado no banco de dados;
        $comando->execute($parametros);        
        //$Contato_ID = $conexao->lastInsertId();
        //Preparando o retorno para o fetch;
        $count = $comando->rowCount();
        $_SESSION["rowCount"] = $count;
        print("
            <script>                
                window.location.href='../../pages/Login.php';
            </script>
        ");    
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