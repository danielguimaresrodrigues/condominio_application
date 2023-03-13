<?php
session_start();

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
            margin: 0 auto !important;
            padding-top: 40px;
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
                border-top-left-radius: 30px !important;
                border-top-right-radius: 30px !important;
                border-bottom-left-radius: 0 !important;
                border-bottom-right-radius: 0 !important;
            }

            #tela {
                width: 100% !important;
            }
        }

        .row {
            background: white;
            border-radius: 30px;
            box-shadow: 12px 12px 22px rgb(211, 210, 210);
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
            border-top-left-radius: 30px;
            border-top-right-radius: 0;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 0;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <section class="Form my-4 mx-auto w-75 align-items-midle" id="tela">
        <div class="container-sm">
            <div class="row g-0">
                <div class="col d-flex align-middle mx-auto" id="fundo-logo">
                    <img src="../assets/img/Logo_Gestorr.svg" alt="" class="img-fluid p-5" id="img" style="width: 100%; height: auto;" />
                </div>
                <div class="col-lg-5 px-5 mx-auto">
                    <h2 class="py-3 text-secondary">Primeiro acesso</h2>
                    <p class="fs-5 text-secondary fw-light">Informe seu e-mail, a senha provisória que recebeu no e-mail
                        e cadastre uma nova senha. Ao finalizar, você será redirecionado a tela de login.</p>
                    <form name="priacesso" action="../edits/editasenhapri.php" method="POST">
                        <?php
                        if (isset($_SESSION['nao_altersenpri'])) :
                        ?>
                            <script>
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Usuário ou senha inválidos!',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>
                        <?php
                        endif;
                        unset($_SESSION['nao_altersenpri']);
                        ?>
                        <?php
                        if (isset($_SESSION['nao_encontrou'])) :
                        ?>
                            <script>
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Usuário não encontrado!',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>
                        <?php
                        endif;
                        unset($_SESSION['nao_encontrou']);
                        ?>
                        <?php
                        if (isset($_SESSION['inativo'])) :
                        ?>
                            <div class="alert alert-danger">
                                <p>AVISO: Acesso negado. Contate o administrador.</p>
                            </div>
                        <?php
                        endif;
                        unset($_SESSION['inativo']);
                        ?>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="email" name="email" placeholder="Insira o e-mail" class="form-control my-3" required>
                                <label for="floatingInput">Insira seu e-mail</label>
                            </div>
                        </div>
                        <div class="form-row border-bottom">
                            <div class="form-floating mb-3">
                                <input type="password" name="senha" id="senha" placeholder="Insira sua senha" class="form-control my-3" required>
                                <label for="floatingInput">Insira sua senha</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="password" name="senhanova" id="senhanova" placeholder="Insira nova senha" class="form-control my-3" required>
                                <label for="floatingInput">Insira nova senha</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <button type="submit" id="edita" class="btn text-center text-decoration-none mt-3 mb-5">Envia</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="assets/js/app.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script type="text/javascript">
    var senha = document.getElementById("senha"),
        senhanova = document.getElementById("senhanova");

    function validaSenha() {
        if (senha.value === senhanova.value) {
            senhanova.setCustomValidity("Senhas devem ser diferentes!");
        } else {
            senhanova.setCustomValidity("");
        }
    }

    senha.onchange = validaSenha;
    senhanova.onkeyup = validaSenha;
</script>