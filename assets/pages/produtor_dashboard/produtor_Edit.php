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

    if (isset($_GET['id_produtor'])) {
        $ID = $_GET['id_produtor'];          
    }    
    
    $comando = $conexao->prepare("SELECT * FROM `produtores` WHERE `ID` = :ID"); 
    $parametros = [":ID" => $ID];
    $comando->execute( $parametros); 

    $linha = $comando->fetch(PDO::FETCH_OBJ);

    $produtor = ["Nome"=>$linha->Nome,
                 "Descricao"=>$linha->Descricao,
                 "imagem_Tipo"=>$linha->Imagem_Tipo];

    // plantação
    $pasta = '../../images/plantacao/';
    $nomeImagem = $ID . "_";
    $padrao = $pasta . "*" . $nomeImagem . "*.{jpg,jpeg,png,gif}";            
    $imagens = glob($padrao, GLOB_BRACE);
    $qtdImagens = count($imagens);
    
    // Endereco
    $comando = $conexao->prepare("SELECT 
                                e.ID AS ID,
                                e.ID_Cidades AS ID_Cidade,
                                e.CEP AS CEP,
                                e.Bairro AS Bairro,
                                e.Rua AS Rua,
                                e.Numero AS Numero,       
                                e.Complemento AS Complemento, 
                                es.ID AS ID_UF
                                FROM `enderecos` e
                                LEFT JOIN cidades ci ON e.ID_Cidades = ci.ID 
                                LEFT JOIN estados es ON ci.ID_UF = es.ID WHERE `ID_Produtores` = :ID"); 

    $parametros = [":ID" => $ID];

    $comando->execute( $parametros); 
    
    $Enderecos = [];

    while ($linha = $comando->fetch(PDO::FETCH_OBJ)) {
        
        $Enderecos[] = ["ID" => $linha->ID,
                      "ID_Cidade" => $linha->ID_Cidade,
                      "CEP" => $linha->CEP,
                      "Bairro" => $linha->Bairro,
                      "Rua" => $linha->Rua,
                      "Numero" => $linha->Numero,
                      "Complemento" => $linha->Complemento,
                      "ID_UF" => $linha->ID_UF];        
    }

    // Contato
    $comando = $conexao->prepare("SELECT * FROM `contatos` WHERE `ID_Produtores` = :ID"); 

    $parametros = [":ID" => $ID];

    $comando->execute( $parametros); 

    $Contatos = [];

    while ($linha = $comando->fetch(PDO::FETCH_OBJ)) {

    $Contatos[] = ["ID" => $linha->ID,
                    "Tipo" => $linha->Tipo,
                    "Texto" => $linha->Texto];        
    }

    // Grupos
    $comando = $conexao->prepare("SELECT * FROM `grupos_produtores` WHERE `ID_Produtores` = :ID"); 

    $parametros = [":ID" => $ID];

    $comando->execute( $parametros); 

    $Grupos = [];

    while ($linha = $comando->fetch(PDO::FETCH_OBJ)) {

    $Grupos[] = ["ID" => $linha->ID,
                 "Grupos" => $linha->Grupo];        
    }

    //Produtos
    $comando = $conexao->prepare("SELECT * FROM `produtos_produtores` WHERE `ID_Produtores` = :ID"); 

    $parametros = [":ID" => $ID];

    $comando->execute($parametros); 

    $Produtos_Produtores = [];

    while ($linha = $comando->fetch(PDO::FETCH_OBJ)) {

    $Produtos_Produtores[] = ["ID" => $linha->ID,
                               "ID_Grupos_Produtores"=>$linha->ID_Grupos_Produtores,
                               "ID_Produtos"=>$linha->ID_Produtos];
    }

    $comando = $conexao->prepare("SELECT * FROM `produtos`"); 

    $comando->execute(); 

    $Produtos = [];

    while ($linha = $comando->fetch(PDO::FETCH_OBJ)) {

    $Produtos[] = ["ID" => $linha->ID,
                   "Nome"=>$linha->Nome,
                   "Grupo"=>$linha->ID_Grupo];        
    }

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
            <h2>Edição do Produtor</h2>
        </div>

        <div class="container mt-4">
            <form action="../../php/produtor_controller/editar_Produtor.php?id_produtor=<?php echo htmlspecialchars($ID)?>" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">
                <div class="form-group p-2">
                    <h2>Produtor</h2>
                    <label for="nome">Nome Completo</label>
                    <input class="form-control" type="text" name="nome" id="txt_nome" value="<?php echo htmlspecialchars($produtor["Nome"])  ?>"> <br>    
                    <label for="descricao">Descrição</label>
                    <textarea class="form-control" name="descricao" rows="5" cols="40"><?php echo htmlspecialchars($produtor["Descricao"])  ?></textarea> <br>        
                    
                    <label for="imagem">Imagem do produtor:</label> <br>
                    <img class="m-1" id="imgPreview" style=' max-height:150px; object-fit: cover' src="../../..<?php echo htmlspecialchars($produtor["imagem_Tipo"])  ?>">
                    <input id="fileInput" class="form-control-file" type="file" name="imagem_nova">
                    <input type="hidden" name="imagem_antiga" value="<?php echo htmlspecialchars($produtor["imagem_Tipo"])?>">
                </div>

                <div class="form-group p-2" id="div_Plantacao">
                    <div>
                        <h2>Plantação</h2>
                        <input class="btn btn-success w-25" type="button" value="Nova Imagem" id="btn_Nova_Plantacao">
                    </div>
                    
                    <?php
                        $cont_Plantacao = 0;
                        if (count($imagens) > 0) {                                            
                            foreach ($imagens as $caminhoImagem) {                                             
                                $cont_Plantacao++;
                                echo " 
                                <div class='form-group' id='div_Plantacao_".$cont_Plantacao."'>             
                                    <hr class='border-dark'>
                                    <label class='d-block' for='plantacao'>Imagem da plantação/produto:</label>
                                    <div class='form-group align-items-center d-flex'>
                                        <img class='m-1' id='img_plantacao_".$cont_Plantacao."' style=' max-height:150px; object-fit: cover' src='".$caminhoImagem."'>                                        
                                        <input type='hidden' name='antiga_plantacao[".$cont_Plantacao."]' value='".$caminhoImagem."'>
                                        <input class='btn btn-danger w-25' type='button' value='Remover Imagem' onclick='remover_Plantacao(this)'>
                                    </div>   
                                </div>";
                            }                                              
                        }
                        $cont_Plantacao++;
                        echo " 
                                <div class='form-group' id='div_Plantacao_".$cont_Plantacao."'>             
                                    <hr class='border-dark'>
                                    <label class='d-block' for='plantacao'>Imagem da plantação/produto:</label>
                                    <div class='form-group align-items-center d-flex'>
                                        <img class='m-1' id='img_plantacao_".$cont_Plantacao."' style=' max-height:150px; object-fit: cover' src=''>
                                        <input class='form-control-file w-75' type='file' id='file_plantacao_".$cont_Plantacao."' name='plantacao[]'>                                        
                                        <input class='btn btn-danger w-25' type='button' value='Remover Imagem' onclick='remover_Plantacao(this)'>
                                    </div>   
                                </div>";
                    ?>                  
                </div>
                
                <div class="form-group p-2" id="div_Endereco">
                    <div>
                        <h2>Endereço</h2>           
                        <input class="btn btn-success w-25" type="button" value="Novo Endereço" id="btn_Novo_Endereco">
                    </div>                    
                    <?php 
                        $comando = $conexao->prepare("SELECT * FROM `estados`");                         
                        $comando->execute();                         
                        $estados = array();

                        while($linha = $comando->fetch(PDO::FETCH_OBJ)) {       
                            $estados[] = array("ID"=> $linha->ID, "Nome"=>$linha->UF);
                        };            

                        $comando = $conexao->prepare("SELECT * FROM `cidades`");
                        $comando->execute(); 
                        $cidades = array();

                        while($linha = $comando->fetch(PDO::FETCH_OBJ)) {        
                            $cidades[] = array("ID"=> $linha->ID, "Nome"=>$linha->Nome, "ID_UF"=> $linha->ID_UF);
                        };            

                        $cont_Endereco = 0; 
                        if (count($Enderecos) > 0) {                
                            foreach ($Enderecos as $EnderecoItem) {
                                $cont_Endereco++; 
                                echo "
                                <div class='form-group p-2' id='div_Endereco_".$cont_Endereco."'>    
                                    <hr class='border-dark'>
                                    <div class='d-flex'>
                                        <div class='form-group w-50 p-1'>
                                            <label for='estado'>Estado</label>
                                            <select class='form-control' id='slct_Estado_".$cont_Endereco."' name='estado[]'>";

                                foreach ($estados as $estado) {
                                    echo "<option value='".$estado["ID"]."' ".($estado["ID"]==$EnderecoItem["ID_UF"]?'selected':'').">". $estado["Nome"]."</option>";   
                                }
                                 
                                echo "      </select>
                                        </div>
                                        <div class='form-group w-50 p-1'>
                                            <label  for='cidade'>Cidade</label>        
                                            <select class='form-control' id='slct_Cidade_".$cont_Endereco."' name='cidade[]'>";

                                foreach ($cidades as $cidade) {
                                    if ($EnderecoItem["ID_UF"] == $cidade["ID_UF"]) {
                                        echo "<option value='".$cidade["ID"]."' ".($cidade["ID"]==$EnderecoItem["ID_Cidade"]?'selected':'').">". $cidade["Nome"]."</option>";   
                                    }
                                }

                                echo "      </select>                        
                                        </div>                            
                                    </div>
                                    <div class='d-flex'>
                                        <div class='form-group col-2 p-1'>
                                            <label for='cep'>CEP</label>        
                                            <input class='form-control' type='text' name='cep[]' value='".htmlspecialchars($EnderecoItem["CEP"])."'>    
                                        </div>
                                        <div class='form-group col-4 p-1'>
                                            <label for='bairro'>bairro</label>        
                                            <input class='form-control' type='text' name='bairro[]' value='".htmlspecialchars($EnderecoItem["Bairro"])."'>
                                        </div>
                                        <div class='form-group col-4 p-1'>
                                            <label for='rua'>rua</label>        
                                            <input class='form-control' type='text' name='rua[]' value='".htmlspecialchars($EnderecoItem["Rua"])."'>
                                        </div>
                                        <div class='form-group col-2 p-1'>
                                            <label for='numero'>numero</label>        
                                            <input class='form-control' type='text' name='numero[]' value='".htmlspecialchars($EnderecoItem["Numero"])."'>
                                        </div>
                                        
                                        
                                    </div>
                                    <label for='complemento'>complemento</label>        
                                    <div class='form-group align-items-center d-flex'>
                                        <input class='form-control' type='text' name='complemento[]' value='".htmlspecialchars($EnderecoItem["Complemento"])."'>                         
                                        <input class='btn btn-danger w-25' type='button' value='Remover Endereço' onclick='remover_Endereco(this)'>                        
                                    </div>
                                    
                                </div>                    
                                ";                                                               
                            }
                        }
                    ?>
                </div>        

                <div class="form-group p-2" id="div_Contato">
                    <div>
                        <h2>Contato</h2>
                        <input class="btn btn-success w-25" type="button" value="Novo Contato" id="btn_Novo_Contato">
                    </div>
                    <?php
                        $cont_Contato = 0; 
                        if (count($Contatos) > 0) {                
                            foreach ($Contatos as $ContatoItem) {
                                $cont_Contato++;
                                echo "<div class='form-group p-2' id='div_Contato_".$cont_Contato."'> 
                                    <hr class='border-dark'>
                                    <label for='tipo'>tipo</label>        
                                    <select class='form-control' name='tipo[]'>            
                                        <option value='1' ".($ContatoItem["Tipo"]=='1'?'selected':'').">Celular</option>
                                        <option value='2' ".($ContatoItem["Tipo"]=='2'?'selected':'').">Telefone Fixo</option>
                                        <option value='3' ".($ContatoItem["Tipo"]=='3'?'selected':'').">Email</option>
                                        <option value='4' ".($ContatoItem["Tipo"]=='4'?'selected':'').">Facebook</option>
                                        <option value='5' ".($ContatoItem["Tipo"]=='5'?'selected':'').">Instagram</option>
                                    </select>        
                                    <label for='texto'>texto</label>        
                                    <div class='form-group align-items-center d-flex'>

                                        <input class='form-control' type='text' name='texto[]' id='txt_texto_".$cont_Contato."' value='".htmlspecialchars($ContatoItem["Texto"])."'>        

                                        <input class='btn btn-danger w-25 w-25' type='button' value='Remover Contato' onclick='remover_Contato(this)'>
                                    </div>
                                </div>";                                
                            }
                        }
                    ?>
                </div>

                <div class="form-group p-2" id="div_Produto">
                    <div>
                        <h2>Produtos</h2>    
                        <input class="btn btn-success w-25" type="button" value="Novo Grupo" id="btn_Novo_Grupo">
                    </div>
                    <?php
                        $cont_Grupo = 0; 
                        $cont_Produto = [];
                        
                        if (count($Grupos) > 0) {                
                            foreach ($Grupos as $GrupoItem) {
                                $cont_Grupo++;              
                                $cont_Produto[] = ["ID_grupo"=>$cont_Grupo, "produtos"=>0];                    
                                echo "
                                <div class='form-group p-2' id='div_Grupo_".$cont_Grupo."'>       
                                    <div id='Grupo_".$cont_Grupo."'>  
                                        <hr class='border-dark'>

                                        <label for='grupo'>Grupo</label>       
                                        <div class='form-group align-items-center d-flex'>
                                            <select class='form-control' id='slct_Grupo_".$cont_Grupo."' name='grupo[]'>            
                                                <option value='0'>Selecione Um Grupo</option>
                                                <option value='1' ".($GrupoItem["Grupos"]=='1'?'selected':'').">Vegetais</option>
                                                <option value='2' ".($GrupoItem["Grupos"]=='2'?'selected':'').">Frutas</option>
                                                <option value='3' ".($GrupoItem["Grupos"]=='3'?'selected':'').">Proteina</option>
                                                <option value='4' ".($GrupoItem["Grupos"]=='4'?'selected':'').">Laticinios</option>
                                                <option value='5' ".($GrupoItem["Grupos"]=='5'?'selected':'').">Processados</option>                                
                                            </select>                                
                                            <input class='btn btn-danger  w-25' type='button' value='Remover Grupo' onclick='remover_Grupo(this)'>
                                            <input class='btn btn-success  w-25' type='button' value='Novo Produto' onclick='adicionar_Produto(this)'>                            
                                        </div>
                                    </div>";
                                    
                                    if (count($Produtos_Produtores) > 0) {                
                                        foreach ($Produtos_Produtores as $Produto_PItem) {                                            
                                            if ($Produto_PItem["ID_Grupos_Produtores"] == $GrupoItem["ID"]) {
                                                foreach ($cont_Produto as &$produto) {
                                                    if ($produto["ID_grupo"] == $cont_Grupo) {                                                        
                                                        $produto["produtos"]++;
                                                        echo "
                                                        <div id='div_Grupo_".$cont_Grupo."_Produto_".$produto["produtos"]."'>                                                            
                                                            <label for='produto'>Produto</label>                            
                                                            <div class='form-group align-items-center d-flex'>
                                                                <select class='form-control' id='slct_Grupo_".$cont_Grupo."_Produto_".$produto["produtos"]."' name='produto[]'>";
                                                                    
                                                        foreach ($Produtos as $Produto) {
                                                            if ($GrupoItem["Grupos"] == $Produto["Grupo"]) {
                                                                echo "<option value='".$Produto["ID"]."' ".($Produto["ID"]==$Produto_PItem["ID_Produtos"]?'selected':'').">". $Produto["Nome"]."</option>";   
                                                            }
                                                        }
    
                                                        echo"                                                                
                                                                </select>
                                                                <input class='btn btn-danger w-25' type='button' value='Remover Produto' onclick='remover_Produto(this)'>
                                                            </div>
                                                        </div>";
                                                        break;
                                                    }
                                                }                                                                                       
                                            }
                                        }
                                    }
                                echo "
                                </div>";
                            }
                        }
                    ?>
                                   
                </div>

                <hr class="border-dark">
                <button type="submit" class="btn btn-custom-1 w-25">Atualizar</button>
                <input type="button" class="btn btn-dark w-25" onclick="location.href = './produtor_Index.php';" value="Voltar">
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>    
    <script>
        let cont_Plantacao = <?php echo($cont_Plantacao==0?  1 :$cont_Plantacao)?>;
        let cont_Endereco = <?php echo($cont_Endereco==0?  1 :$cont_Endereco)?>;
        let cont_Contato = <?php echo($cont_Contato==0? 1 :$cont_Contato)?>;     
        let cont_Grupo = <?php echo($cont_Grupo==0? 1 :$cont_Grupo)?>;        
        let cont_Produto = <?php echo json_encode($cont_Produto); ?>;

        function selecionar_Cidade(val) {
            var ID_UF = $("#slct_Estado_"+val+" option:selected").val();
            $.ajax({
                type: "GET",
                data: { ID_UF: ID_UF },
                url: "../../php/endereco_controller/selecionar_Cidade.php",
                dataType: "json",
                success: function (dados) {
                    if (dados != null) {
                        var selectbox = $('#slct_Cidade_'+val);
                        $("#slct_Cidade_"+val).empty();
                        $('<option>').val("0").text("Selecione a Cidade").appendTo(selectbox);
                        $.each(dados, function (i, d) {                            
                            $('<option>').val(d.ID).text(d.Nome).appendTo(selectbox);
                        })
                    }
                }

            });
        }

        function selecionar_Estado(val) {            
            $.ajax({
                type: "GET",
                url: "../../php/endereco_controller/selecionar_UF.php",
                dataType: "json",
                success: function (dados) {
                    if (dados != null) {
                        var selectbox = $('#slct_Estado_'+val);
                        $("#slct_Estado_"+val).empty();
                        $('<option>').val("0").text("Selecione uma UF").appendTo(selectbox);
                        $.each(dados, function (i, d) {
                            $('<option>').val(d.ID).text(d.Nome).appendTo(selectbox);
                        })
                    }
                }

            });
        }

        function selecionar_Produto(val) {
            var ID_Grupo = $("#slct_Grupo_"+val+" option:selected").val();
            
            $.ajax({
                type: "GET",
                data: { ID_Grupo: ID_Grupo },
                url: "../../php/produto_controller/selecionar_Produto.php",
                dataType: "json",
                success: function (dados) {
                    if (dados != null) {                                                
                        for (let j = 1; j < $("#div_Grupo_" + val).children().length; j++) {
                            var selectbox = $("#div_Grupo_" + val).children().eq(j).children().eq(1).children().eq(0);
                            if (j == $("#div_Grupo_" + val).children().length - 1) {
                                selectbox.empty();
                                $('<option>').val("0").text("Selecione um Produto").appendTo(selectbox[0]);
                                $.each(dados, function (i, d) {                            
                                    $('<option>').val(d.ID).text(d.Nome).appendTo(selectbox[0]);
                                })       
                            }                                                        
                        }
                        
                    }
                }

            });
        }         

        function adicionar_Produto(btn) {
            let div_Grupo = $(btn).parent().parent().parent();
            let newProduto = $(div_Grupo).children().eq(1).clone();
            let ID_Grupo = parseInt(div_Grupo[0].id.charAt(div_Grupo[0].id.length - 1));
            let posicao = 0;

            for (let i = 0; i < cont_Produto.length; i++) {
                if(cont_Produto[i].ID_grupo == ID_Grupo){
                    cont_Produto[i].produtos++;
                    posicao = i;
                }
            }
            
            newProduto[0].id = "div_Grupo_" + ID_Grupo+"_Produto_"+cont_Produto[posicao].produtos;
            newProduto[0].children[1].children[0].id = "slct_Grupo_" + ID_Grupo+"_Produto_"+cont_Produto[posicao].produtos;
            $('#div_Grupo_'+ID_Grupo).append(newProduto);
                              
            selecionar_Produto(cont_Produto[posicao].ID_grupo, cont_Produto[posicao].produtos);
        }                

        function remover_Plantacao(div) {
            if ($('#div_Plantacao').children().length != 2) {
                $(div).parent().parent().remove();
            }
        }

        function remover_Endereco(div) {
            if ($('#div_Endereco').children().length != 2) {
                $(div).parent().parent().remove();
            }
        }

        function remover_Contato(div) {
            if ($('#div_Contato').children().length != 2) {
                $(div).parent().parent().remove();
            }
        }
        
        function remover_Grupo(div) {
            if ($('#div_Produto').children().length != 2) {
                $(div).parent().parent().parent().remove();
                
            }
        }

        function remover_Produto(div) {            
            if ($(div).parent().parent().parent().children().length != 2) {
                $(div).parent().parent().remove();                                
            }
        }

        $(document).ready(function () {   
            $("#slct_Estado_1").change( () =>{
                selecionar_Cidade(1);
            });

            $("#slct_Grupo_1").change( () =>{
                selecionar_Produto(1);
            });

            // Funções de manipulação da plantação
            $('#btn_Nova_Plantacao').click(function () {
                let newPlantacao = $('#div_Plantacao').children().eq(1).clone();
                cont_Plantacao++;
                newPlantacao[0].id = "div_Plantacao_" + cont_Plantacao;                
                $('#div_Plantacao').append(newPlantacao);
            }); 

            // Funções de manipulação de endereços
            $('#btn_Novo_Endereco').click(function () {
                let newEndereco = $('#div_Endereco').children().eq(1).clone();
                cont_Endereco++;
                newEndereco[0].id = "div_Endereco_" + cont_Endereco;
                newEndereco[0].children[1].children[0].children[1].id = "slct_Estado_" + cont_Endereco;
                newEndereco[0].children[1].children[1].children[1].id = "slct_Cidade_" + cont_Endereco;
                $('#div_Endereco').append(newEndereco);

                selecionar_Estado(cont_Endereco);                                    
                $("#slct_Estado_" + cont_Endereco).on( "change" , () =>{
                    selecionar_Cidade(cont_Endereco);
                });

                var selectbox = $('#slct_Cidade_'+cont_Endereco);
                $("#slct_Cidade_"+cont_Endereco).empty();
                $('<option>').val("0").text("Selecione uma UF").appendTo(selectbox);
            });             

            // Funções de manipulação de contatos
            $('#btn_Novo_Contato').click(function () {
                let newContato = $('#div_Contato').children().eq(1).clone();
                cont_Contato++;
                newContato[0].id = "div_Contato_" + cont_Contato;                
                $('#div_Contato').append(newContato);
            });                                   

            // Funções de manipulação de grupos
            $('#btn_Novo_Grupo').click(function () {
                let newGrupo = $('#div_Produto').children().eq(1).clone();
                cont_Grupo++;

                cont_Produto.push({ ID_grupo: cont_Grupo, produtos: 1 });
                for (let i = 0; i < cont_Produto.length; i++) {
                    if(cont_Produto[i].ID_grupo == cont_Grupo){
                        posicao = i;
                    }
                }

                newGrupo[0].id = "div_Grupo_" + cont_Grupo;
                newGrupo[0].children[0].id = "Grupo_" + cont_Grupo;
                newGrupo[0].children[0].children[2].children[0].id = "slct_Grupo_" + cont_Grupo;
                newGrupo[0].children[1].id = "div_Grupo_" + cont_Grupo + "_Produto_" + cont_Produto[posicao].produtos;
                newGrupo[0].children[1].children[1].children[0].id = "slct_Grupo_" + cont_Grupo + "_Produto_" + cont_Produto[posicao].produtos;
                $('#div_Produto').append(newGrupo);
                
                $("#slct_Grupo_" + cont_Grupo).on( "change" , () =>{
                    selecionar_Produto(cont_Grupo);
                });

                var selectbox = $("#slct_Grupo_" + cont_Grupo + "_Produto_" + cont_Produto[posicao].produtos);
                selectbox.empty();
                $('<option>').val("0").text("Selecione um Grupo").appendTo(selectbox);
            });             

            
        });

        const fileInput = document.getElementById('fileInput');
        const imgPreview = document.getElementById('imgPreview');

        fileInput.addEventListener('change', function() {
            const file = fileInput.files[0];
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

        for (let i = 1; i <= cont_Plantacao; i++) {
            let file_plantacao = document.getElementById('file_plantacao_'+i);
            let img_plantacao = document.getElementById('img_plantacao_'+i);
            if(file_plantacao != null){
                file_plantacao.addEventListener('change', function() {
                    let file = file_plantacao.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            img_plantacao.src = e.target.result;
                            img_plantacao.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        img_plantacao.style.display = 'none';
                        img_plantacao.src = "";
                    }
                });
            }
        }
    </script>
</body>
</html>