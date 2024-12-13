<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia do Produtor - Início</title>
    <!-- BootStrap 5 -->
    <link rel="stylesheet" href="./assets/styles/bootstrap.css" >

    <link rel="stylesheet" href="./assets/styles/index.css">
    <link rel="stylesheet" href="./assets/styles/padrao.css">
    <link rel="stylesheet" href="./assets/styles/loader.css">
</head>
<body style="overflow-x: hidden;">
    <div class="loader"></div>
    <!-- Header Start -->
    <div class="container-fluid bg-light position-relative shadow">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
          <a href="./index.php" class="navbar-brand font-weight-bold text-secondary" style="font-size: 45px">
            <img height="100" width="100" src="./assets/images/icones/Logotipo.png"></img>
          </a>
          <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end " id="navbarCollapse">
            <div class="navbar-nav font-weight-bold ">
              <a href="./index.php" class="m-0 pb-0 nav-item nav-link active h4">Inicio</a>
              <a href="./assets/pages/produtores.php" class="m-0 pb-0 nav-item nav-link h4">Produtores</a>                                        
              <a href="./assets/pages/login.php" class="m-0 pb-0 nav-item nav-link h4">Login</a>
            </div>
          </div>
        </nav>
    </div>
    <!-- Header End -->

    <!-- Content Start -->
        <!-- Carousel Start -->
        <div id="carouselExampleIndicators" class="carousel slide" style="max-height: 80vh;" data-bs-ride="carousel">
            <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
            </div>
            <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./assets/images/carrosel/carrosel_1.jpg" style="max-height: 80vh;" class="d-block w-100 img-fluid" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./assets/images/carrosel/carrosel_2.jpg" style="max-height: 80vh;" class="d-block w-100 img-fluid" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./assets/images/carrosel/carrosel_3.jpg" style="max-height: 80vh;" class="d-block w-100 img-fluid" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./assets/images/carrosel/carrosel_4.jpg" style="max-height: 80vh;" class="d-block w-100 img-fluid" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./assets/images/carrosel/carrosel_5.jpg" style="max-height: 80vh;" class="d-block w-100 img-fluid" alt="...">
            </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!-- Carousel End -->

        <!-- Producers Start -->
        <div id="producer_Div" class="container pt-3">
            <div class="row text-center justify-content-center">
                <h1>Produtores</h1>
                <hr class="w-25 rounded normal-bar" >
            </div>
            <?php require_once("./assets/php/produtor_controller/listar_Index_Produtor.php");?>

        </div>
        <!-- Producers End -->
        
        <!-- About Us Start-->
        <div class="content pt-3" style="overflow-x: hidden">
            <div class="row text-center justify-content-center">
                <h1 >Sobre Nós</h1>
                <hr class="w-25 rounded normal-bar" >
            </div>

            <div class="row position-relative about-us-content">
                <div class="bg-custom-1 shadow" id="about_Us_1" onclick="abrir_Sobre_Nos(0)">
                    <div class="container mt-5">
                        <h2>A Unoeste</h2>
                        <p>A Universidade do Oeste Paulista (Unoeste) nasceu em Presidente Prudente do sonho dos professores Agripino de Oliveira Lima Filho e Ana Cardoso Maia de Oliveira Lima em oferecer ensino superior de excelência para a região. Desde 1972, a Unoeste cresceu, tornando-se a única universidade particular do oeste paulista, com uma infraestrutura moderna e extensa, presente também em outras cidades, como Jaú e Guarujá, e oferecendo cursos a distância para todo o Brasil e até no Japão. Esse compromisso com a educação transforma vidas e fortalece o desenvolvimento local e regional.</p>
                    </div>    
                </div>                    
                <div class="bg-custom-2 shadow" id="about_Us_2" onclick="abrir_Sobre_Nos(1)">
                    <div class="container mt-5">
                        <h2>O Curso de Gastronomia</h2>
                        <p>O curso de Gastronomia da Unoeste é voltado para quem deseja transformar a paixão pela cozinha em uma carreira sólida e bem fundamentada. Com uma abordagem que vai além de receitas, o curso oferece aprendizado em técnicas e conhecimentos culturais, econômicos e sociais do mundo da alimentação. Com aulas práticas em cozinhas nacionais e internacionais, o curso capacita o aluno para atuar no mercado gastronômico, seja em restaurantes, hotéis, empresas de eventos, entre outros. Os alunos também têm acesso a bibliotecas e a um ambiente virtual de aprendizagem que apoia sua formação contínua, preparando-os para se destacar no setor.</p>
                    </div>
                </div>                    
                <div class="bg-custom-3 shadow" id="about_Us_3" onclick="abrir_Sobre_Nos(2)">
                    <div class="container mt-5">
                        <h2>O Projeto</h2>
                        <p>Este projeto, realizado pelos alunos de Gastronomia da Unoeste, tem como objetivo mapear e conectar pequenos produtores da região de Presidente Prudente com empresas e consumidores. Inspirado pelo movimento locavorista, que valoriza o consumo de produtos locais, o projeto busca fortalecer a economia local, promover práticas de sustentabilidade e incentivar a visibilidade dos produtores da região. Dessa forma, contribuímos para uma cadeia de abastecimento mais justa e acessível, beneficiando todos os envolvidos e promovendo uma alimentação mais consciente e próxima da nossa realidade.</p>
                    </div>
                </div>                                                   
            </div>
            
        </div>
        <!-- About Us End-->

        <!-- Team Start -->
        <div style="position: relative; height: 600px;" class="container pt-3">
            <div class="row text-center justify-content-center">
                <h1 >Equipe</h1>
                <hr class="w-25 rounded normal-bar" >
            </div>

            <div class="row text-center justify-content-center mt-4">
                <div onclick="trocar_Categoria('P')" id="txt_Carrosel_Professores" class="w-50 align-items-center text-center flex-wrap d-flex flex-column align-content-end pb-3">
                    <h5 class="m-0" >Professores</h5>
                    <hr class="w-75 rounded m-0" style="height: 2px; background-color: black; opacity: 1;">
                </div>
                <div onclick="trocar_Categoria('A')" id="txt_Carrosel_Alunos" class="w-50  align-items-center text-center flex-wrap d-flex flex-column align-content-start pb-3">
                    <h5 class="m-0" >Alunos</h5>
                    <hr class="w-75 rounded m-0" style="height: 2px; background-color: black; opacity: 1;">
                </div>
            </div>
            <?php require_once("./assets/php/equipe_controller/listar_Index_Equipe.php");?>

        </div>
        <!-- Team End -->

        <!-- Contact Start-->         
        <div class="container-fluid py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-5 mb-lg-0">
                        <div class="row text-center justify-content-center">
                            <h1 >Entre em Contato Conosco</h1>
                            <hr class="w-25 rounded" >
                        </div>                        
                        <ul class="list-inline m-0">
                            <li class="py-2">
                            <i class="fa fa-check text-success mr-3"></i>Estamos aqui para ajudar! Caso tenha dúvidas, sugestões ou precise de mais informações sobre nossos produtos e serviços, não hesite em nos contatar. Nossa equipe terá o prazer em atendê-lo o mais breve possível.
                            </li>
                            <li class="py-2">
                            <i class="fa fa-check text-success mr-3"></i>Utilize o formulário abaixo para enviar sua mensagem, e retornaremos assim que possível.
                            </li>

                    </ul>

                    </div>
                    <div class="col-lg-5 bg-dark px-4 pt-4 pb-5 card border-0 shadow">
                    
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
        <!-- Contact End-->         

    <!-- Content End -->

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
                        <li><a href="./index.html" class="text-light">Inicio</a></li>
                        <li><a href="./assets/pages/produtores.php" class="text-light">Produtores</a></li>
                        <li><a href="./assets/pages/login.php" class="text-light">Login</a></li>
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


    <!-- BootStrap 5 -->
    <script src="./assets/scripts/bootstrap.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="./assets/scripts/index.js"></script>
    <script src="./assets/scripts/loader.js"></script>
    <script src="./assets/scripts/contate_nos.js"></script>
</body>
</html>