<?php
session_start();

//$id_empresa
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>gestorr | Gestão para Condomínios</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--link rel="stylesheet" href="assets/css/style.css" media="screen" /-->
    <!--link rel="stylesheet" href="assets/css/light-box.css" media="screen"/-->

    <!--Token gerado consulta cnpj!
    4496a8196df7095ae5d93820ce3718618fefd1255d7021506ac9d8da8aae6cb1-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="apple-touch-icon" sizes="57x57" href="../assets/img/ico/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../assets/img/ico/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../assets/img/ico/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/ico/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../assets/img/ico/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../assets/img/ico/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../assets/img/ico/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../assets/img/ico/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/ico/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../assets/img/ico/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../assets/img/ico/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/ico/favicon-16x16.png">
    <link rel="manifest" href="../assets/img/ico/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../assets/img/ico/ms-icon-144x144.png">
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
            padding-top: 40px;
            padding-bottom: 40px;
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

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        function validarPost() {
            if (grecaptcha.getResponse() != "") return true;
            swal("ATENÇÃO!", "Selecione a caixa 'Não sou um robô'.", "info");
            return false;
        }
    </script>
    <!--script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <section class="Form my-4 mx-auto w-75 align-items-midle" id="tela">
        <div class="container-sm">
            <div class="row g-0">
                <div class="col" id="fundo-logo">
                    <img src="../assets/img/Logo_Gestorr.svg" alt="" class="img-fluid p-5" id="img" style="width: 100%; height: auto;" />
                </div>
                <div class="col-lg-5 px-5 mx-auto">
                    <p class="fs-4 py-3 text-secondary">Cadastro do responsável | gestorr</p>
                    <form action="../edits/registraResponsavel.php" method="POST">
                        <?php
                        if (isset($_SESSION['status_cadastro'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Parabéns!", "Cadastro efetuado! Agora informe os dados do responsável.", "info");
                            </script-->
                            <script>
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Cadastro efetuado! Agora informe os dados do responsável.',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>
                        <?php
                        endif;
                        unset($_SESSION['status_cadastro']);
                        ?>
                        <?php
                        if (isset($_SESSION['usuario_existe'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Atenção!", "O CNPJ escolhido já existe. Informe outro e tente novamente.", "warning");
                            </script-->
                            <script>
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Atenção!',
                                    text: 'O CNPJ escolhido já existe. Informe outro e tente novamente.',
                                    timer: 3000
                                })
                            </script>
                        <?php
                        endif;
                        unset($_SESSION['usuario_existe']);
                        ?><script type="text/javascript">
                            document.addEventListener('DOMContentLoaded', function() {
                                setTimeout(function() {
                                    $("#msg_exist").fadeOut().empty();
                                }, 6000);
                            }, false);
                        </script>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="hidden" value="<?php echo $_SESSION['id_empresa']; ?>" name="idcond" placeholder="ID do condomínio" class="form-control my-3">
                                <label for="floatingInput">Insira o ID do condomínio</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="text" value="<?php echo $_SESSION['responsavel']; ?>" name="nomeresp" id="nomeresp" placeholder="Nome completo" class="form-control my-3 text-uppercase" required readonly>
                                <label for="floatingInput">Nome do responsável</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="text" value="<?php echo $_SESSION['cpfResp']; ?>" name="cpf" id="cpf" placeholder="CPF do responsável" class="form-control my-3" required readonly>
                                <label for="floatingInput">CPF do responsável</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="perfil" id="perfil" required>
                                    <option value="1">Administrador</option>
                                    <option value="2">Síndico</option>
                                </select>
                                <label for="floatingInput">Selecione o perfil</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="email" name="email" id="email" placeholder="Insira o e-mail" class="form-control my-3 text-lowercase" required>
                                <label for="floatingInput">Insira o e-mail do responsável</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="text" value="<?php echo $_SESSION['celular']; ?>" name="celular" id="celular" placeholder="Insira seu celular" class="form-control my-3" required>
                                <label for="floatingInput">Insira o celular do responsável</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="text" name="rg_id" id="rg_id" placeholder="Insira o RG do responsável" class="form-control my-3" onkeypress="return restrictNumbers(event)" required>
                                <label for="floatingInput">Insira o RG do responsável</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="date" name="nasc" id="nasc" placeholder="Nascimento do responsável" class="form-control my-3" required>
                                <label for="floatingInput">Nascimento do responsável</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="text" name="cep" id="cep" placeholder="Insira seu cep" class="form-control my-3" onblur="pesquisacep(this.value);" required>
                                <label for="floatingInput">Insira o cep do responsável</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="text" name="rua" id="rua" placeholder="Insira sua rua" class="form-control my-3 text-uppercase" required>
                                <label for="floatingInput">Insira a rua do responsável</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="text" name="numero" id="numero" placeholder="Insira o número" class="form-control my-3" required>
                                <label for="floatingInput">Insira o número</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="text" name="complemento" id="complemento" placeholder="Complemento opcional" class="form-control my-3 text-uppercase" onkeypress="return restrictNumbers(event)">
                                <label for="floatingInput">APTO (opcional)</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="text" name="bloco" id="bloco" placeholder="Complemento opcional" class="form-control my-3 text-uppercase" onkeypress="return restrictNumbers(event)">
                                <label for="floatingInput">Bloco (opcional)</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="text" name="bairro" id="bairro" placeholder="Digite seu bairro" class="form-control my-3 text-uppercase" required>
                                <label for="floatingInput">Insira o bairro do responsável</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="uf" id="uf" required readonly>
                                    <option value="AC">AC</option>
                                    <option value="AL">AL</option>
                                    <option value="AP">AP</option>
                                    <option value="AM">AM</option>
                                    <option value="BA">BA</option>
                                    <option value="CE">CE</option>
                                    <option value="DF">DF</option>
                                    <option value="ES">ES</option>
                                    <option value="GO">GO</option>
                                    <option value="MA">MA</option>
                                    <option value="MT">MT</option>
                                    <option value="MS">MS</option>
                                    <option value="MG">MG</option>
                                    <option value="PA">PA</option>
                                    <option value="PB">PB</option>
                                    <option value="PR">PR</option>
                                    <option value="PE">PE</option>
                                    <option value="PI">PI</option>
                                    <option value="RJ">RJ</option>
                                    <option value="RN">RN</option>
                                    <option value="RS">RS</option>
                                    <option value="RO">RO</option>
                                    <option value="RR">RR</option>
                                    <option value="SC">SC</option>
                                    <option value="SP">SP</option>
                                    <option value="SE">SE</option>
                                    <option value="TO">TO</option>
                                </select>
                                <label for="floatingInput">Selecione a unidade</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-floating mb-3">
                                <input type="text" name="cidade" id="cidade" placeholder="Digite sua codade" class="form-control my-3 text-uppercase" required>
                                <label for="floatingInput">Digite a cidade do responsável</label>
                            </div>
                        </div>
                        <div class="g-recaptcha mb-3" data-sitekey="6Ld5swQkAAAAAJ3HhCVkYDLA31qRfIVCpbjlgekl"></div>
                        <div class="form-row">
                            <!--button type="submit" class="btn text-center text-decoration-none mt-3 mb-5" onclick="return validaRe()">Enviar</button-->
                            <button type="submit" class="btn text-center text-decoration-none mt-3 mb-5">Enviar</button>
                        </div>
                        <div class="form-row mb-5">
                            <a class="text-decoration-none" href="../index.php">Efetue login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="../assets/js/app.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.mask.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#cpf").mask("000.000.000-00")
            $("#cnpj").mask("00.000.000/0000-00")
            $("#celular").mask("(00) 00000-0000")
            $("#valor").mask("999.999.990,00", {
                reverse: true
            })
            $("#cep").mask("00.000-000")
            $("#dataNascimento").mask("00/00/0000")

            $("#rg").mask("999.999.999-W", {
                translation: {
                    'W': {
                        pattern: /[X0-9]/
                    }
                },
                reverse: true
            })

            var options = {
                translation: {
                    'A': {
                        pattern: /[A-Z]/
                    },
                    'a': {
                        pattern: /[a-zA-Z]/
                    },
                    'S': {
                        pattern: /[a-zA-Z0-9]/
                    },
                    'L': {
                        pattern: /[a-z]/
                    },
                }
            }

            $("#placa").mask("AAA-0000", options)

            $("#codigo").mask("AA.LLL.0000", options)

            $("#celular").mask("(00) 00000-0009")

            $("#celular").blur(function(event) {
                if ($(this).val().length == 15) {
                    $("#celular").mask("(00) 00000-0009")
                } else {
                    $("#celular").mask("(00) 00000-0009")
                }
            })
        })
    </script>

    <script type="text/javascript">
        function restrictNumbers(e) {
            var x = e.which || e.keycode;
            if ((x >= 48 && x <= 57))
                return true;
            else
                return false;
        }
    </script>

</body>

</html>