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
            <h2>Cadastro do Produtor</h2>
        </div>

        <div class="container mt-4">
            <form action="../../php/produtor_controller/cadastrar_Produtor.php" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">
                <div class="form-group p-2">
                    <h2>Produtor</h2>
                    <label for="nome">Nome Completo</label>
                    <input class="form-control" type="text" name="nome" id="txt_nome"> <br>    
                    <label for="descricao">Descrição</label>
                    <textarea class="form-control" name="descricao" rows="5" cols="40"></textarea> <br> 
                           
                    <label for="imagem">Imagem do produtor:</label>
                    <input class="form-control-file" type="file" name="imagem">
                </div>

                <div class="form-group p-2" id="div_Plantacao">
                    <div>
                        <h2>Plantação</h2>
                        <input class="btn btn-success w-25" type="button" value="Nova Imagem" id="btn_Nova_Plantacao">
                    </div>
                    <div class="form-group" id="div_Plantacao_1">             
                        <hr class="border-dark">
                        <label class="d-block" for="plantacao">Imagem da plantação/produto:</label>
                        <div class="form-group align-items-center d-flex">
                            <input class="form-control-file w-75" type="file" name="plantacao[]">
                            <input class="btn btn-danger w-25" type="button" value="Remover Imagem" onclick="remover_Plantacao(this)">
                        </div>                     
                    </div> 
                </div>
                
                <div class="form-group p-2" id="div_Endereco">
                    <div>
                        <h2>Endereço</h2>           
                        <input class="btn btn-success w-25" type="button" value="Novo Endereço" id="btn_Novo_Endereco">
                    </div>                    
                    <div class="form-group p-2" id="div_Endereco_1">    
                    <hr class="border-dark">
                        <div class="d-flex">
                            <div class="form-group w-50 p-1">
                                <label for="estado">Estado</label>
                                <select class="form-control" id="slct_Estado_1" name='estado[]'>
                                    <option value='0'>Selecione uma UF</option>
                                </select>
                            </div>
                            <div class="form-group w-50 p-1">
                                <label  for="cidade">Cidade</label>        
                                <select class="form-control" id="slct_Cidade_1" name="cidade[]">            
                                    <option value="0">Selecione uma UF</option>            
                                </select>                        
                            </div>                            
                        </div>
                        <div class="d-flex">
                            <div class="form-group col-2 p-1">
                                <label for="cep">CEP</label>        
                                <input class="form-control" type="text" name="cep[]">    
                            </div>
                            <div class="form-group col-4 p-1">
                                <label for="bairro">bairro</label>        
                                <input class="form-control" type="text" name="bairro[]">
                            </div>
                            <div class="form-group col-4 p-1">
                                <label for="rua">rua</label>        
                                <input class="form-control" type="text" name="rua[]">
                            </div>
                            <div class="form-group col-2 p-1">
                                <label for="numero">numero</label>        
                                <input class="form-control" type="text" name="numero[]">
                            </div>
                            
                            
                        </div>
                        <label for="complemento">complemento</label>        
                        <div class="form-group align-items-center d-flex">
                            <input class="form-control" type="text" name="complemento[]">                         
                            <input class="btn btn-danger w-25" type="button" value="Remover Endereço" onclick="remover_Endereco(this)">                        
                        </div>
                        
                    </div>                    
                </div>        

                <div class="form-group p-2" id="div_Contato">
                    <div>
                        <h2>Contato</h2>
                        <input class="btn btn-success w-25" type="button" value="Novo Contato" id="btn_Novo_Contato">
                    </div>
                    <div class="form-group p-2" id="div_Contato_1"> 
                        <hr class="border-dark">
                        <label for="tipo">tipo</label>        
                        <select class="form-control" name="tipo[]">            
                            <option value="1">Celular</option>
                            <option value="2">Telefone Fixo</option>
                            <option value="3">Email</option>
                            <option value="4">Facebook</option>
                            <option value="5">Instagram</option>
                        </select>        
                        <label for="texto">texto</label>        
                        <div class="form-group align-items-center d-flex">

                            <input class="form-control" type="text" name="texto[]" id="txt_texto_1">        

                            <input class="btn btn-danger w-25 w-25" type="button" value="Remover Contato" onclick="remover_Contato(this)">
                        </div>
                    </div>
                </div>

                <div class="form-group p-2" id="div_Produto">
                    <div>
                        <h2>Produtos</h2>    
                        <input class="btn btn-success w-25" type="button" value="Novo Grupo" id="btn_Novo_Grupo">
                    </div>
                
                    <div class="form-group p-2" id="div_Grupo_1">            
                        <div id="Grupo_1">  
                            <hr class="border-dark">

                            <label for="grupo">Grupo</label>       
                            <div class="form-group align-items-center d-flex">
                                <select class="form-control" id="slct_Grupo_1" name="grupo[]">            
                                    <option value="0">Selecione Um Grupo</option>
                                    <option value="1">Vegetais</option>
                                    <option value="2">Frutas</option>
                                    <option value="3">Proteina</option>
                                    <option value="4">Laticinios</option>
                                    <option value="5">Processados</option>                                
                                </select>                                
                                <input class="btn btn-danger  w-25" type="button" value="Remover Grupo" onclick="remover_Grupo(this)">
                                <input class="btn btn-success  w-25" type="button" value="Novo Produto" onclick="adicionar_Produto(this)">                            
                            </div>
                        </div>
                        
                        <div id="div_Grupo_1_Produto_1">
                            <label for="produto">Produto</label>                            
                            <div class="form-group align-items-center d-flex">
                                <select class="form-control" id="slct_Grupo_1_Produto_1" name="produto[]">
                                    <option value="">Selecione um Grupo</option>
                                </select>
                                <input class="btn btn-danger w-25" type="button" value="Remover Produto" onclick="remover_Produto(this)">
                            </div>
                        </div>                        
                    </div>                    
                </div>

                
                <hr class="border-dark">
                <button type="submit" class="btn btn-custom-1 w-25">Cadastrar</button>
                <input type="button" class="btn btn-dark w-25" onclick="location.href = './produtor_Index.php';" value="Voltar">
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>    
    <script>
        let cont_Plantacao = 1;
        let cont_Endereco = 1;
        let cont_Contato = 1;        
        let cont_Grupo = 1;        
        let cont_Produto = [{ID_grupo:1, produtos:1},];

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

        function selecionar_Produto(val, mudou_Grupo) {
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
                            if(mudou_Grupo){
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
                              
            selecionar_Produto(cont_Produto[posicao].ID_grupo, false);
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
            selecionar_Estado(1);
            $("#slct_Estado_1").change( () =>{
                selecionar_Cidade(1);
            });

            $("#slct_Grupo_1").change( () =>{
                selecionar_Produto(1, true);
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
                    selecionar_Produto(cont_Grupo, true);
                });

                var selectbox = $("#slct_Grupo_" + cont_Grupo + "_Produto_" + cont_Produto[posicao].produtos);
                selectbox.empty();
                $('<option>').val("0").text("Selecione um Grupo").appendTo(selectbox);
            });             

        });
    </script>
</body>
</html>	