<?php 
if (isset($_GET['id_produtor'])) {
    $ID_P = $_GET['id_produtor'];          
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia do Produtor - Produtor</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/padrao.css">
    <link rel="stylesheet" href="../styles/loader.css">
</head>
<body>
    <div class="loader"></div>
    <!-- Header Start -->
    <div class="container-fluid bg-light position-relative shadow">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
          <a href="../../index.php" class="navbar-brand font-weight-bold text-secondary" style="font-size: 45px">
            <img height="100" width="100" src="../images/icones/Logotipo.png"></img>
          </a>
          <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end " id="navbarCollapse">
            <div class="navbar-nav font-weight-bold ">
              <a href="../../index.php" class="m-0 pb-0 nav-item nav-link active h4">Inicio</a>
              <a href="./produtores.php" class="m-0 pb-0 nav-item nav-link h4">Produtores</a>                                        
              <a href="./login.php" class="m-0 pb-0 nav-item nav-link h4">Login</a>
            </div>
          </div>
        </nav>
    </div>

    <div id="div_Principal" class="container mt-5 mb-5 p-4 border rounded bg-light">
        <?php
            require_once("../php/conexao.php");    

            // Preparar o comando SQL para enviar ao banco de dados;
            $comando = $conexao->prepare("SELECT 
                                                p.ID AS Produtor_ID,
                                                p.Nome AS Produtor_Nome,
                                                p.Descricao AS Produtor_Descricao,
                                                p.Data_De_Cadastro AS Produtor_Data_De_Cadastro,
                                                p.Imagem_Tipo AS Produtor_Imagem_Tipo,
                                                GROUP_CONCAT(DISTINCT gp.Grupo) AS Grupo_Produtores_Grupo,
                                                GROUP_CONCAT(DISTINCT prod.Nome) AS Produtos_Nome,
                                                GROUP_CONCAT(DISTINCT CONCAT_WS('|', e.Rua, e.Numero, e.Bairro, e.Complemento, ci.Nome, es.UF)) AS Enderecos,
                                                GROUP_CONCAT(DISTINCT CONCAT(c.Tipo, ':', c.Texto)) AS Contatos
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
                                                p.ID = :ID");

            $parametros = [":ID" => $ID_P];
            $comando->execute($parametros);
            
            while ($linha = $comando->fetch(PDO::FETCH_OBJ)) {
                switch ($linha->Grupo_Produtores_Grupo) {
                    case 1:
                        $strTipo = "Vegetais";                
                        break;
                    case 2:
                        $strTipo = "Frutas";                
                        break;
                    case 3:
                        $strTipo = "Proteina";                
                        break;
                    case 4:
                        $strTipo = "Laticinios";                
                        break;
                    case 5:
                        $strTipo = "Processados";                
                        break;
                    default:
                        $strTipo = "Nenhum";                
                        break;
                }
                $pasta = '../images/plantacao/';
                $nomeImagem = $linha->Produtor_ID . "_";
                $padrao = $pasta . "*" . $nomeImagem . "*.{jpg,jpeg,png,gif}";
                $imagens = glob($padrao, GLOB_BRACE);
                if (count($imagens) > 0) { $imagenRand = $imagens[array_rand($imagens)]; }
                else { $imagenRand = $linha->Produtor_Imagem_Tipo; }
                echo ("
                    <div class='row position-relative'>
                        <div class='p-4 col-sm-4 position-relative'><img style='max-height: 90%;' class='d-block w-100 img-fluid shadow' src='" . ($linha->Produtor_Imagem_Tipo == "/assets/images/produtores/0.jpg"? $imagenRand : "../../" . $linha->Produtor_Imagem_Tipo) . "' alt=''></div>
                        <div class='p-4 col-sm-8 position-relative'>
                            <div class='row'>
                                <h1>Nome: " . $linha->Produtor_Nome . "</h1>
                            </div>
                            <div class='row'>
                                <h4>Descrição:</h4>
                                <p>" . $linha->Produtor_Descricao . "</p>                    
                            </div>  
                        </div>
                    </div>
                    <hr class='border-dark'>
                    <div class='row'>
                        <div class='p-4 col-sm-4 position-relative'>
                                <h4>Contatos:<br></h4>                     
                                <ul style='list-style-type:none; padding: 0'>");

                $pares = explode(',', $linha->Contatos);
                foreach ($pares as $par) {
                    list($indice, $telefone) = explode(':', $par);
                    switch ($indice) {
                        case '1':
                            print( "<li>Celular: " . $telefone . "</li>");
                            break;
                        case '2':
                            print( "<li>Telefone Fixo: " . $telefone . "</li>");                
                            break;
                        case '3':
                            print( "<li>Email: " . $telefone . "</li>");            
                            break;
                        case '4':
                            print( "<li>Facebook: " . $telefone . "</li>");        
                            break;
                        case '5':
                            print( "<li>Instagram: " . $telefone . "</li>");    
                            break;
                        default:                    
                            break;
                    }            
                }
                echo ( "         </ul>
                    </div>
                    <div class='p-4 col-sm-4 position-relative'>
                        <div class='row'>
                            <h4>Endereço:</h4>                    
                        </div>
                        <div class='row'>
                            <ul style='list-style-type:none; padding: 0'>");

                $enderecos = explode('?', $linha->Enderecos);
                foreach ($enderecos as $endereco) {
                    $endereco = $endereco;
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
                    
                    print( "<li>" . ltrim($endereco_completo, ', ') . "</br></li>");
                }
                echo ( "         </ul>
                        </div>
                    </div>
                    <div class='p-4 col-sm-4 position-relative'>
                        <div class='row'>
                            <h4>Grupo:".$strTipo."</h4>                    
                        </div>
                        <div class='row'>
                            <ul style='list-style-type:none; padding: 0'>
                                <li style='word-break: break-word; white-space: normal;'>" . $linha->Produtos_Nome . ",</li>
                            </ul>                    
                        </div>
                    </div>");

                // Adicionar imagens
                print( "
                    <div class='container p-0'>
                        <h4>Imagens:</h4>
                        <div class='row'>");                

                if ($imagens) {                
                    foreach ($imagens as $caminhoImagem) {
                        print( "
                            <div class='col-md-4 mb-4'>                    
                                <img class='d-block w-100 img-fluid shadow' src='" . $caminhoImagem . "' class='card-img-top img-fluid' alt='Imagem'>
                            </div>");
                    }
                } else {
                    print( "<p>Nenhuma imagem encontrada.</p>");
                }

                print( "</div></div>");
            }
        ?>
    </div>
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light py-5">
        <div class="container">
            <div class="row">
                <!-- Sobre Nós -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="text-uppercase mb-4" style="font-size: 1.5rem;">O Projeto</h5>
                    <p>
                        Projeto dos alunos de Gastronomia da Unoeste conecta pequenos produtores locais a consumidores e empresas, fortalecendo a economia, promovendo sustentabilidade e valorizando produtos regionais.
                    </p>                    
                </div>

                <!-- Navegação Rápida -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="text-uppercase mb-4" style="font-size: 1.5rem;">Navegação Rápida</h5>
                    <ul class="list-unstyled">
                        <li><a href="../../index.php" class="text-light">Inicio</a></li>
                        <li><a href="./produtores.php" class="text-light">Produtores</a></li>
                        <li><a href="./login.php" class="text-light">Login</a></li>
                    </ul>
                </div>

                <!-- Contato -->
                <div class="col-lg-4 col-mb-6 ">
                        <h5 class="text-uppercase mb-4 font-weight-bold text-white">Contato</h5>
                        <form onsubmit="enviar_Mensagem(this,event); return false"  method="get">
                            <div class="form-group mb-3">
                                <input type="text" class="form-control" placeholder="Nome" required>
                            </div>
                            <div class="form-group mb-3">
                                <input type="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group mb-3">
                                <textarea class="form-control" rows="3" placeholder="Sua mensagem" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-custom-1 btn-block">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
    <script src="../scripts/loader.js"></script>
    <script src="../scripts/contate_nos.js"></script>
</body>
</html>
					