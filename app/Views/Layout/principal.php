<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ordem de Serviço | <?php echo $this->renderSection('titulo'); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href=" <?php echo site_url('recursos/'); ?>vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href=" <?php echo site_url('recursos/'); ?>vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="<?php echo site_url('recursos/'); ?>css/font.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?php echo site_url('recursos/'); ?>css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo site_url('recursos/'); ?>css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href=" <?php echo site_url('recursos/'); ?>img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->


    <!--- ESPAÇOS PARA RENDERIZAR OS STYLES DE CADA VIEW ------------------------>

    <?php echo $this->renderSection('styles'); ?>

    <!--------------------------------------------------------------------------->

</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="search-panel">
                <div class="search-inner d-flex align-items-center justify-content-center">
                    <div class="close-btn">Close <i class="fa fa-close"></i></div>
                    <form id="searchForm" action="#">
                        <div class="form-group">
                            <input type="search" name="search" placeholder="Digite aqui...">
                            <button type="submit" class="submit">Pesquisar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <div class="navbar-header">
                    <!-- Navbar Header--><a href="<?php echo site_url('/') ?>" class="navbar-brand">
                        <div class="brand-text brand-big visible text-uppercase"><strong class="text-info">CRUD </strong><strong>Simples</strong></div>
                        <div class="brand-text brand-sm"><strong class="text-info">C</strong><strong>S</strong></div>
                    </a>
                    <!-- Sidebar Toggle Btn-->
                    <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
                </div>
                <div class="right-menu list-inline no-margin-bottom">
                    <div class="list-inline-item"><a href="#" class="search-open nav-link"><i class="icon-magnifying-glass-browser"></i></a></div>

                    <!-- Languages dropdown    -->
                    <div class="list-inline-item">
                        <a class="dropdown-toggle">
                            <span class="d-none d-sm-inline-block">Olá, <?php echo usuario_logado()->nome; ?></span>
                        </a>
                    </div>
                    <!-- Log out               -->
                    <div class="list-inline-item logout">
                        <a id="logout" href="<?php echo site_url('logout') ?>" class="nav-link">Sair <i class="icon-logout"></i></a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="d-flex align-items-stretch">
        <!-- Sidebar Navigation-->
        <nav id="sidebar">
            <!-- Sidebar Header-->
            <div class="sidebar-header d-flex align-items-center">
                <div class="avatar"><img src=" <?php echo site_url('recursos/img/perfil0.png'); ?>" alt="..." class="img-fluid rounded-circle"></div>
                <div class="title text-center">
                    <h1 class="h5"><?php echo usuario_logado()->nome; ?></h1>
                    <p>Atendente</p>
                </div>
            </div>
            <!-- Sidebar Navidation Menus--><span class="heading">Painel</span>
            <ul class="list-unstyled">

                <!--ALTERADO PARA APRESENTAR ACTIVER NOS ICONES DA PÁGINA QUE ESTIVER LOGADO -->
                <li class="<?php echo (url_is('/') ? 'active' : '') ?>"><a href="<?php echo site_url('/') ?>"> <i class="icon-home"></i>Home </a></li>
                <li class="<?php echo (url_is('usuarios*') ? 'active' : '') ?>"><a href="<?php echo site_url('usuarios') ?>"> <i class="icon-user"></i>Usuários </a></li>
                <li class="<?php echo (url_is('grupos*') ? 'active' : '') ?>"><a href="<?php echo site_url('grupos') ?>"> <i class="icon-settings"></i>Grupos & Permissões </a></li>
                <!--<li class="<?php  ?>"><a href="charts.html"> <i class="fa fa-bar-chart"></i>Charts </a></li>
                <li class="<?php ?>"><a href="forms.html"> <i class="icon-padnote"></i>Forms </a></li>-->
                <!--<li><a href="<?php #echo site_url('usuarios/editarSenha'); 
                                    ?>"> <i class="icon-settings"></i>Alterar senha </a></li>-->
            </ul>

        </nav>
        <!-- Sidebar Navigation end-->
        <div class="page-content">
            <div class="page-header">
                <div class="container-fluid">
                    <h2 class="h5 no-margin-bottom"><?php echo $titulo ?></h2>
                </div>
            </div>
            <section class="no-padding-top no-padding-bottom">


                <div class="container-fluid">

                    <?php echo $this->include('Layout/_mensagens'); ?>

                    <!------------ ESPAÇOS PARA RENDERIZAR OS CONTEUDOS DE CADA VIEW ------------>

                    <?php echo $this->renderSection('conteudo'); ?>

                    <!--------------------------------------------------------------------------->

                </div>


            </section>

            <footer class="footer">
                <div class="footer__block block no-margin-bottom">
                    <div class="container-fluid text-center">
                        <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                        <p class="no-margin-bottom"><?php echo date('Y'); ?> &copy; Desenvolvido por <a target="_blank" href="https://templateshub.net">Ataides Jr</a>.</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="<?php echo site_url('recursos/'); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo site_url('recursos/'); ?>vendor/popper.js/umd/popper.min.js"> </script>
    <script src="<?php echo site_url('recursos/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo site_url('recursos/'); ?>jqueryValidation/jquery.validate.min.js"></script>
    <script src="<?php echo site_url('recursos/'); ?>js/front.js"></script>


    <!------------ ESPAÇOS PARA RENDERIZAR OS SCRIPTS DE CADA VIEW -------------->

    <?php echo $this->renderSection('scripts'); ?>

    <!--------------------------------------------------------------------------->

    <script>
        $(function() {
            $('[data-toggle="popover"]').popover({
                html: true,
            })
        })
    </script>

</body>

</html>