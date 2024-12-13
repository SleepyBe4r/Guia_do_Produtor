<?php 
    if (session_status() == PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['localhost'])) $scriptPath = "/Guia_do_Produtor/assets/php/verificar_secao.php";
    else $scriptPath = "/assets/php/verificar_secao.php";
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $scriptPath; 
    
    require_once($fullPath);  

    // Caminho do script, você pode definir conforme necessário
    if (session_status() == PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['localhost'])) $scriptPath = "/Guia_do_Produtor/assets/php/conexao.php";
    else $scriptPath = "/assets/php/conexao.php";

    // Caminho absoluto usando DOCUMENT_ROOT
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $scriptPath;
    
    // Inclui o arquivo PHP com o caminho absoluto
    require_once($fullPath);  
            
    header("Access-Control-Allow-Origin: *"); 

    if (isset($_GET['id_produto'])) {
        $ID = $_GET['id_produto'];          
    }    

    // Produtor
    $comando = $conexao->prepare("SELECT * FROM `produtos` WHERE `ID` = :ID"); 
    $parametros = [":ID" => $ID];
    $comando->execute( $parametros); 

    $linha = $comando->fetch(PDO::FETCH_OBJ);

    $produto = ["Nome"=>$linha->Nome,
               "Grupo"=>$linha->ID_Grupo];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../styles/padrao.css">
</head>
<body>

    <!-- Menu Lateral -->
    <div class="sidebar">
        <h4 class="text-center">Painel de Controle</h4>
        <nav class="nav flex-column">
            <a class="nav-link" href="../../../index.php">Início</a>
            <a class="nav-link" href="../dashboard.php">Dashboard</a>
            <a class="nav-link" href="../equipe_dashboard/equipe_Index.php">Equipe</a>
            <a class="nav-link" href="../produtor_dashboard/produtor_Index.php">Produtores</a>
            <a class="nav-link" href="./produto_Index.php">Produtos</a>
            <!-- <a class="nav-link" href="#">Configurações</a> -->
            <a class="nav-link" href="../../php/admin_controller/logout.php">Sair</a>
        </nav>
    </div>

    <!-- Conteúdo Principal -->
    <div class="main-content">
        <div class="content-header">
            <h2>Edição do Produto</h2>
        </div>

        <div class="container mt-4">
            <form action="../php/produto_controller/editar_Produto.php?id_produto=<?php echo htmlspecialchars($ID)?>" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">
                <div class="form-group">
                    <label for="grupo">Grupo</label>          
                    <select class="form-control" name="grupo">            
                        <option value="1" <?php echo $produto["Grupo"]=='1'?'selected':'';?>>Vegetais</option>
                        <option value="2" <?php echo $produto["Grupo"]=='2'?'selected':'';?>>Frutas</option>
                        <option value="3" <?php echo $produto["Grupo"]=='3'?'selected':'';?>>Proteina</option>
                        <option value="4" <?php echo $produto["Grupo"]=='4'?'selected':'';?>>Laticinios</option>
                        <option value="5" <?php echo $produto["Grupo"]=='5'?'selected':'';?>>Processados</option>                                
                    </select>
                </div>

                <div class="form-group">
                    <label for="nome">Nome do Produto</label>
                    <input type="text" class="form-control" name="nome" placeholder="Digite o nome do produto" value="<?php echo htmlspecialchars($produto["Nome"])?>" required>
                </div>

                <hr class="border-dark">
                <button type="submit" class="btn btn-custom-1 w-25">Atualizar</button>
                <input type="button" class="btn btn-dark w-25" onclick="location.href = './produto_Index.php';" value="Voltar">
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
