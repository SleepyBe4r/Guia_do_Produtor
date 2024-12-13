<?php 
    try
    {        
        //Declaração e inicialização das variaveis necessária ao banco de dados;        

        /* My SQL Variables*/ {
            $servidor_MySQL = "localhost"; // OU  $servidor = "127.0.0.1";
            $banco_de_dados_MySQL = "guiadoprodutor02";    
            $usuario_MySQL = "root";
            $senha_MySQL = "";     
        }    
        
        $string_PDO_MySQL = "mysql:host=".$servidor_MySQL."; dbname=".$banco_de_dados_MySQL;
        $conexao = new PDO($string_PDO_MySQL, $usuario_MySQL, $senha_MySQL);
        $conexao->exec('SET CHARACTER SET utf8');                

        if (session_status() == PHP_SESSION_NONE) session_start();
        if($servidor_MySQL == "localhost") $_SESSION['localhost'] = true;
    }
    catch(PDOException $ex)
    {
        echo "Erro ao conectar ao banco de dados: " . $ex->getMessage();
    }
?>		