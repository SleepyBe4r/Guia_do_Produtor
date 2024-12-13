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
            <a class="nav-link" href="./produtor_Index.php">Produtores</a>
            <a class="nav-link" href="../produto_dashboard/produto_Index.php">Produtos</a>
            <!-- <a class="nav-link" href="#">Configurações</a> -->
            <a class="nav-link" href="../../php/admin_controller/logout.php">Sair</a>
        </nav>
    </div>

    <!-- Conteúdo Principal -->
    <div class="main-content">
        <div class="content-header">
            <h2>Produtores</h2>
            <p>Aqui você pode gerenciar informações dos Produtores.</p>
            <a href="./produtor_Create.php" class="btn btn-success">Adicionar Produtor</a>
        </div>

        <div class="container mt-4">
        <div class="card mt-4">
            <div class="card-header">Produtores</div>
                <div class="card-body">                    
                    <?php require_once("../../php/produtor_controller/listar_Produtor.php") ?>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.0/dist/umd/popper.min.js"></script>
    <script src="../libraries/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script>
        function remover_Produtor(ID) {                 
            var resultado = confirm("Deseja REMOVER o Produtor?");
            if (resultado == true) {       
                $.ajax({
                    type: "GET",
                    data: { ID_Produtor: ID },
                    url: "../../php/produtor_controller/remover_Produtor.php",
                    dataType: "json",
                    success: function (dados) {
                        $("#"+ID).remove();
                    }
                });
            }
        }

        function editar_Produtor(ID) {                                         
            location.href = `./produtor_Edit.php?id_produtor=${ID}`;           
        }
    </script>          
</body>
</html>