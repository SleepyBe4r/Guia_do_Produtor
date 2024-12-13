<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia do Produtor - Produtores</title>
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
    <!-- Header End -->

    <div class="container mt-5 mb-5 p-4 border rounded bg-light">
        <div class="row">
            <?php require_once("../php/produtor_controller/listar_Produtores.php");?>
            
            
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
    <script>
        function ver_Mais(id) {           
            window.location.href='./produtor_Tudo.php?id_produtor='+id;                        
        }
     </script>
</body>
</html>		