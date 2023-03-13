<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>gestorr | Gestão para Condomínios</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/navbar.css" rel="stylesheet">
    <link href="../assets/css/headers.css" rel="stylesheet">
    <!--link href="assets/css/styles_sidebar.css" rel="stylesheet"-->
    <!--link href="assets/css/sidebar.css" rel="stylesheet"-->
    <!--Sidebar do bootstrap-->
    <!--link href="../assets/css/sidebars.css" rel="stylesheet"-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/print_dashboard.css">
    <link rel="stylesheet" href="../assets/css/virtual-select.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css"-->
    <link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css">
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet">
    <script src="../assets/js/script.js" defer></script>

    <style>
        #fundo-logo {
            background-image: radial-gradient(#f0c810 50%, #f59829);
        }

        /*#fundo {

            background-image: linear-gradient(#f1f6fb 60%, #fff);
        }*/

        #salva,
        #crop {
            border: none;
            outline: none;
            border: 1px solid rgb(45, 105, 175);
            width: 100%;
            background-color: white;
            color: rgb(45, 105, 175);
            border-radius: 4px;
            font-weight: bold;
            align-items: center;
        }

        /*.container {
            min-height: 94vh;
            overflow-y: scroll;
        }*/

        #salva:hover,
        #crop:hover {
            background: rgb(45, 105, 175);
            border: 1px solid rgb(45, 105, 175);
            color: white;

        }

        #busca {
            border: none;
            outline: none;
            border: 1px solid rgb(45, 105, 175);

            background-color: white;
            color: rgb(45, 105, 175);
            border-radius: 4px;
            font-weight: bold;
            align-items: center;
            border-top-left-radius: 0 !important;
            border-top-right-radius: 4px !important;
            border-bottom-left-radius: 0 !important;
            border-bottom-right-radius: 4px !important;
        }

        #busca:hover {
            background: rgb(45, 105, 175);
            border: 1px solid rgb(45, 105, 175);
            color: white;
        }

        #edita {
            border: none;
            outline: none;
            border: 1px solid rgb(45, 105, 175);
            width: 100%;
            background-color: rgb(45, 105, 175);
            color: white;
            border-radius: 4px;
            font-weight: bold;
            align-items: center;
        }

        #edita:hover {
            background: white;
            border: 1px solid rgb(45, 105, 175);
            color: rgb(45, 105, 175);

        }

        #volta {
            border: none;
            outline: none;
            border: 1px solid rgb(45, 105, 175);
            width: 100%;
            background-color: white;
            /*color: rgb(45, 105, 175);*/
            border-radius: 4px;
            font-weight: bold;
            align-items: center;
        }

        nav {
            position: fixed;
        }

        #volta:hover {
            background: rgb(100, 100, 100);
            border: 1px solid rgb(45, 105, 175);
            color: white;
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

        .bg-atencao {
            background-color: #FFFACD !important;
        }

        .bg-taleturquoise {
            background-color: #E0FFFF !important;
        }

        .uploaded_image {
            display: block;
            max-width: 100%;
        }

        .image_area {
            position: relative;
        }

        .preview {
            overflow: hidden;
            width: 160px;
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }

        .overlay {
            position: absolute;
            bottom: 10px;
            left: 0;
            right: 0;
            background-color: rgba(255, 255, 255, 0.5);
            overflow: hidden;
            height: 0;
            transition: .5s ease;
            width: 100%;
        }

        .image_area:hover .overlay {
            height: 50%;
            cursor: pointer;
        }

        .text {
            color: #333;
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            text-align: center;
        }
    </style>

    <script type="text/javascript">
        function getDados() {

        }
    </script>

    <script type="text/javascript">
        function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value = ("");
            document.getElementById('bairro').value = ("");
            document.getElementById('cidade').value = ("");
            document.getElementById('uf').value = ("");

        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('rua').value = (conteudo.logradouro);
                document.getElementById('bairro').value = (conteudo.bairro);
                document.getElementById('cidade').value = (conteudo.localidade);
                document.getElementById('uf').value = (conteudo.uf);

            } //end if.
            else {
                //CEP não Encontrado.
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }

        function pesquisacep(valor) {

            //Nova variável "cep" somente com dígitos.
            var cep = valor.replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    document.getElementById('rua').value = "...";
                    document.getElementById('bairro').value = "...";
                    document.getElementById('cidade').value = "...";
                    document.getElementById('uf').value = "...";

                    //Cria um elemento javascript.
                    var script = document.createElement('script');

                    //Sincroniza com o callback.
                    script.src = '//viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                    //Insere script no documento e carrega o conteúdo.
                    document.body.appendChild(script);

                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        };
    </script>
    <!--script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--script src="../assets/js/iniciar.js"></script-->
    <!--script src="../assets/js/sidebars.js"></script-->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!--script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script-->

    <script type="text/javascript" src="../assets/js/jquery.mask.min.js"></script>
    <script src="https://unpkg.com/dropzone"></script>
    <script src="https://unpkg.com/cropperjs"></script>
    <!--script type="text/javascript" src="../assets/js/jquery-3.5.1.min.js"></script-->


</head>