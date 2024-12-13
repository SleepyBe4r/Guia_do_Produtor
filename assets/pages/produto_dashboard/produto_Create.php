<?php 
    if (session_status() == PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['localhost'])) $scriptPath = "/Guia_do_Produtor/assets/php/verificar_secao.php";
    else $scriptPath = "/assets/php/verificar_secao.php";
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $scriptPath; 
    
    require_once($fullPath);  
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
            <h2>Cadastro de Produto</h2>
        </div>

        <div class="container mt-4">
            <form action="../../php/produto_controller/cadastrar_Produto.php" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">
                <div class="form-group">
                    <label for="grupo">Grupo</label>          
                    <select class="form-control" name="grupo">            
                        <option value="1">Vegetais</option>
                        <option value="2">Frutas</option>
                        <option value="3">Proteina</option>
                        <option value="4">Laticinios</option>
                        <option value="5">Processados</option>                                
                    </select>
                </div>

                <div class="form-group">
                    <label for="nome">Nome do Produto</label>
                    <input type="text" class="form-control" name="nome" placeholder="Digite o nome do produto" required>
                </div>

                <hr class="border-dark">
                <button type="submit" class="btn btn-custom-1 w-25">Cadastrar</button>
                <input type="button" class="btn btn-dark w-25" onclick="location.href = './produto_Index.php';" value="Voltar">
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
