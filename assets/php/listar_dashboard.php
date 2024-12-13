
<?php
    require_once("conexao.php");

    print("<div class='row'>");

    $comando = $conexao->prepare("SELECT * FROM `produtores`"); 
    
    $comando->execute(); 
    $count = $comando->rowCount();                        

    print("
        <div class='col-md-4'>
            <div class='card text-white bg-primary mb-3'>
                <div class='card-header'>Produtores</div>
                <div class='card-body'>
                    <h5 class='card-title'>" . $count ."</h5>
                    <p class='card-text'>Total de produtores cadastrados.</p>
                </div>
            </div>
        </div>
    ");     

    $comando = $conexao->prepare("SELECT * FROM `produtos`"); 
    
    $comando->execute(); 
    $count = $comando->rowCount();                        

    print("
        <div class='col-md-4'>
            <div class='card text-white bg-success mb-3'>
                <div class='card-header'>Produtos</div>
                <div class='card-body'>
                    <h5 class='card-title'>" . $count ."</h5>
                    <p class='card-text'>Total de produtos cadastrados.</p>
                </div>
            </div>
        </div>
    ");     

    $comando = $conexao->prepare("SELECT * FROM `pedidos`"); 
    
    $comando->execute(); 
    $count = $comando->rowCount();                        

    print("
        <div class='col-md-4'>
            <div class='card text-white bg-warning mb-3'>
                <div class='card-header'>Pedidos Pendentes</div>
                <div class='card-body'>
                    <h5 class='card-title'>" . $count ."</h5>
                    <p class='card-text'>Pedidos que aguardam processamento.</p>
                </div>
            </div>
        </div>
    ");     

    print("</div>");

    $comando = $conexao->prepare("SELECT * FROM `pedidos`"); 
      
    //Execultar o comando preparado no banco de dados;

    
    $comando->execute(); 

    print("
     <div class='card mt-4'>
        <div class='card-header'>Últimos Pedidos</div>
            <div class='card-body'>
                <table class='table table-striped'>
                    <thead>
                        <tr>
                            <th class='d-none d-lg-table-cell'>ID</th>
                            <th class='d-none d-md-table-cell'>Cliente</th>
                            <th class='d-none d-lg-table-cell'>Email</th>
                            <th class='d-none d-xl-table-cell'>Mensagem</th>  
                            <th class='d-none d-md-table-cell'>Ações</th>
                        </tr>
    ");     

    while($linha = $comando->fetch(PDO::FETCH_OBJ))        
    {    
        print("        
            <tr id='" . $linha->ID ."'>               
                <td class='d-none d-lg-table-cell'>" . $linha->ID . "</td>
                <td class='d-none d-md-table-cell'>" . $linha->Nome . "</td>
                <td class='d-none d-lg-table-cell'>" . $linha->Email . "</td>                
                <td class='d-none d-xl-table-cell'>" . $linha->Mensagem . "</td>                
                
                <td class='d-none d-md-table-cell'> <button class='btn btn-danger' onclick='remover_Pedido(this.parentNode.parentNode.id)'>Remover Pedido</button> </td>
            </tr>                            
        ");
    };            
    
    print("</tbody></table></div></div>");

?>