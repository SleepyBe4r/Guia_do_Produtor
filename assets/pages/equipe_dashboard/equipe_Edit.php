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

    if (isset($_GET['id_equipe'])) {
        $ID = $_GET['id_equipe'];          
    }    

    // Produtor
    $comando = $conexao->prepare("SELECT * FROM `equipe` WHERE `ID` = :ID"); 
    $parametros = [":ID" => $ID];
    $comando->execute( $parametros); 

    $linha = $comando->fetch(PDO::FETCH_OBJ);

    $equipe = ["Nome"=>$linha->Nome,
                "Tipo"=>$linha->Tipo,
                "Ano"=>$linha->Ano,
                "imagem_Tipo"=>$linha->Imagem_Tipo];

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
            <a class="nav-link" href="./equipe_Index.php">Equipe</a>
            <a class="nav-link" href="../produtor_dashboard/produtor_Index.php">Produtores</a>
            <a class="nav-link" href="../produto_dashboard/produto_Index.php">Produtos</a>
            <!-- <a class="nav-link" href="#">Configurações</a> -->
            <a class="nav-link" href="../../php/admin_controller/logout.php">Sair</a>
        </nav>
    </div>

    <!-- Conteúdo Principal -->
    <div class="main-content">
        <div class="content-header">
            <h2>Edição de Membro da Equipe</h2>
        </div>

        <div class="container mt-4">
            <form action="../php/equipe_controller/editar_Equipe.php?id_equipe=<?php echo htmlspecialchars($ID)?>" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">
                <div class="form-group">                    
                    <label for="tipo">Tipo</label>
                    <select class="form-control" name="tipo" id="slct_tipo" required>
                        <option value="" disabled>Selecione o Tipo</option>
                        <option value="P" <?php echo $equipe["Tipo"]=='P'?'selected':'';?>>Professor</option>
                        <option value="A" <?php echo $equipe["Tipo"]=='A'?'selected':'';?>>Aluno</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" class="form-control" name="nome" id="txt_nome" placeholder="Digite o nome completo" value="<?php echo htmlspecialchars($equipe["Nome"])?>" required>
                </div>

                <div class="form-group">
                    <label for="ano">Ano do Projeto</label>
                    <input type="number" class="form-control" name="ano" id="dt_ano" placeholder="YYYY" min="1999" max="2020" value="<?php echo htmlspecialchars($equipe["Ano"])?>" required>
                </div>

                <div class="form-group">
                    <label for="imagem_nova">Imagem</label>
                    <img class="m-1" id="imgPreview" style=' max-height:150px; object-fit: cover' src="../../..<?php echo htmlspecialchars($equipe["imagem_Tipo"])  ?>">
                    <input type="file" class="form-control-file" id="fileInput" name="imagem_nova" accept="image/*" >
                    <input type="hidden" name="imagem_antiga" value="<?php echo htmlspecialchars($equipe["imagem_Tipo"])  ?>">
                </div>

                <hr class="border-dark">
                <button type="submit" class="btn btn-custom-1 w-25">Atualizar</button>
                <input type="button" class="btn btn-dark w-25" onclick="location.href = './equipe_Index.php';" value="Voltar">
            </form>
        </div>
    </div>

    <script>
        document.getElementById("dt_ano").max = new Date().getFullYear();  // Atualiza o ano máximo com o ano atual

        const fileInput = document.getElementById('fileInput');
        const imgPreview = document.getElementById('imgPreview');

        fileInput.addEventListener('change', function() {
            
            
            const file = fileInput.files[0];
            console.log(file.name);
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imgPreview.style.display = 'none';
                imgPreview.src = "";
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
