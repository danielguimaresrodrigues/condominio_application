<?php
session_start();

/*if (isset($_SESSION['nao_autenticado'])) {
    header('Location: index.php');

    die();
}*/
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>gestorr | Gestão para Condomínios</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--link rel="stylesheet" href="assets/css/style.css" media="screen" /-->
    <!--link rel="stylesheet" href="assets/css/light-box.css" media="screen"/-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="apple-touch-icon" sizes="57x57" href="assets/img/ico/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/img/ico/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/img/ico/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/ico/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/img/ico/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/ico/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/img/ico/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/img/ico/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/ico/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/img/ico/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/ico/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/ico/favicon-16x16.png">
    <link rel="manifest" href="assets/img/ico/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/img/ico/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background: rgb(219, 226, 226);
            align-items: center;
            /*margin: 0 auto !important;
            padding-top: 40px;*/
            /*padding-bottom: 40px;*/
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        @media (max-width: 768px) {
            #fundo-logo {
                width: 100%;
                min-height: auto !important;
                padding: 10px;
                /*border-top-left-radius: 30px !important;
                border-top-right-radius: 30px !important;
                border-bottom-left-radius: 0 !important;
                border-bottom-right-radius: 0 !important;*/
            }

            /*#tela {
                width: 100% !important;
            }*/
        }

        .row {
            background: white;
            /*border-radius: 30px;
            box-shadow: 12px 12px 22px rgb(211, 210, 210);*/
        }

        /*#img {
            top: 50%;
            left: 50%;
            margin-top: -50px;
            margin-left: -50px;
        }*/

        .btn {
            border: none;
            outline: none;
            border: 1px solid rgb(45, 105, 175);
            width: 100%;
            background-color: rgb(45, 105, 175);
            color: white;
            border-radius: 4px;
            font-weight: 500;
            align-items: center;
        }

        .btn:hover {
            background: white;
            border: 1px solid rgb(45, 105, 175);
            color: rgb(45, 105, 175);

        }

        #bt-enviar {
            border: none;
            outline: none;
            border: 1px solid rgb(45, 105, 175);
            width: 50%;
            background-color: rgb(45, 105, 175);
            color: white;
            border-radius: 4px;
            font-weight: 500;
            align-items: center;
        }

        #bt-enviar:hover {
            background: white;
            border: 1px solid rgb(45, 105, 175);
            color: rgb(45, 105, 175);

        }

        .notification-danger {
            border: none;
            /*border-bottom: 1px solid white;*/
            background: rgba(180, 11, 27, 0.8);
            text-align: center;
            color: #fff;
            border-radius: 5px;
            padding: 15px;
        }

        #fundo-logo {
            background-image: radial-gradient(#eaf2fc 30%, #d3e4f7);
            /*border-top-left-radius: 30px;
            border-top-right-radius: 0;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 0;*/
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!--script>
        function validarPost() {
            if (grecaptcha.getResponse() != "") return true;
            swal("ATENÇÃO", "Selecione a caixa 'Não sou um robô'", "info");
            return false;
        }
    </script-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <section class="Form align-items-midle" id="tela">
        <!--div class="container-sm"-->
        <div class="row g-0">
            <div class="col-sm-8 d-flex align-middle min-vh-100" id="fundo-logo">
                <img src="assets/img/Logo_Gestorr.svg" alt="" class="img-fluid p-5" id="img" style="width: 100%; height: auto;" />
            </div>
            <div class="col-lg-4 px-5 align-items-midle min-vh-100">
                <h2 class="py-3 text-secondary">Login gestorr</h2>
                <form action="db/login.php" method="POST">
                    <?php
                    if (isset($_SESSION['nao_autenticado'])) :
                    ?>
                        <script type="text/javascript">
                            Swal.fire({
                                icon: 'warning',
                                title: "Usuário ou senha inválidos!",
                                showConfirmButton: false,
                                timer: 3000
                            })
                        </script>

                    <?php
                    endif;
                    unset($_SESSION['nao_autenticado']);
                    ?>
                    <?php
                    if (isset($_SESSION['bloq'])) :
                    ?>
                        <script type="text/javascript">
                            swal("AVISO!", "Usuário precisa de liberação pelo administrador.", "info");
                        </script>
                    <?php
                    endif;
                    unset($_SESSION['bloq']);
                    ?>
                    <?php
                    if (isset($_SESSION['inativo'])) :
                    ?>
                        <script type="text/javascript">
                            Swal.fire({
                                icon: 'info',
                                title: 'Atenção!',
                                text: "<?php echo $_SESSION['msg']; ?>",
                                timer: 8000
                            })
                        </script>
                    <?php
                    endif;
                    unset($_SESSION['inativo']);
                    ?>
                    <?php
                    if (isset($_SESSION['reseta_senha'])) :
                    ?>
                        <script type="text/javascript">
                            Swal.fire({
                                icon: 'warning',
                                title: 'Atenção!',
                                text: <?php $_SESSION['msg'] ?>
                            })
                        </script>
                    <?php
                    endif;
                    unset($_SESSION['reseta_senha']);
                    ?>
                    <div class="form-row">
                        <div class="form-floating mb-3">
                            <input type="email" name="email" placeholder="Insira o e-mail" class="form-control my-3" required>
                            <label for="floatingInput">Insira seu e-mail</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-floating mb-3">

                            <input type="password" name="senha" placeholder="Insira sua senha" class="form-control my-3" required>
                            <label for="floatingInput">Insira sua senha</label>


                        </div>
                    </div>
                    <div class="g-recaptcha mb-3" data-sitekey=""></div>
                    <div class="form-row">
                        <!--button type="submit" class="btn text-center text-decoration-none mt-3 mb-5" onclick="return validaRe()">Login</button-->
                        <button type="submit" class="btn text-center text-decoration-none mt-3 mb-5">Login</button>
                    </div>
                    <a class="text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#modal-add" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente">Esqueceu sua senha?</a><br>
                    <!--a class="text-decoration-none" href="painel">Acesso</a-->
                    <p class=" text-secondary">Ainda não tem uma conta? <a class="text-decoration-none" href="cadastros/acesso/access">Clique aqui!</a></p>
                </form>
            </div>
        </div>
        <!--/div-->
    </section>

    <div class="modal fade" id="modal-add">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Esqueci minha senha</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="container my-5" id="email" align="center">
                        <div class="col-12">
                            <form action="cadastros/esquecisenha.php" method="POST" id="staticform" onsubmit="return validarPost()">
                                <div class="form-group mb-3 text-start">
                                    <label for="nome">E-mail</label>
                                    <input class="form-control" type="email" name="emaill" id="emaill" placeholder="Digite o e-mail cadastrado" required>
                                </div>
                                <div class="g-recaptcha mb-3" data-sitekey=""></div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-outline-primary rounded-3" id="bt-enviar">ENVIAR</button>
                                </div>
                                <div class="alert alert-danger d-none">
                                    Preencha o campo <span id="campo-erro"></span>!
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/app.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script>
        function validarPost() {
            if (grecaptcha.getResponse() == "") {
                Swal.fire({
                    icon: 'info',
                    title: "Selecione a caixa 'Não sou um robô'",
                    showConfirmButton: false,
                    timer: 3000
                })
                return false;
            }
        }
    </script>
</body>

</html>