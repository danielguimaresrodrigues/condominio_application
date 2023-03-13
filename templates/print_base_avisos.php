<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>gestorr | Gestão para Condomínios - Relatórios</title>
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
    <!--link href="../assets/css/headers.css" rel="stylesheet"-->
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
    <script src="../assets/js/script.js" defer></script>

    <style>
        body {
            background: #fff;
        }
    </style>
</head>

<body>

    <header>
        <nav class="menu bg-white py-2 border-bottom no_print no_print">
            <div class="toggle border-bottom" onclick="toggleMenu();"></div>
            <div class="logo"><a><img class="img-fluid" src="../assets/img/Symbol-gestorr-horizontal.svg"></a></div>
            <form action="../exportar/exportexcelquadrodeavisos.php" method="POST">
                <div class="d-grid d-flex gap-2">

                    <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Data Inicial(venc.)">
                        <input class="form-control  form-control-sm" type="date" name="data_ini" id="data_ini" placeholder="Data">
                    </span>

                    <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Data Final(venc.)">
                        <input class="form-control  form-control-sm" type="date" name="data_fim" id="data_fim" placeholder="Data">
                    </span>

                    <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Filtrar">
                        <button type="button" class="btn btn-sm btn-outline-primary center-block" id="filtrar" onclick="listarAvisos()"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </span>
                    <span>
                        <button type="button" class="btn btn-sm btn-outline-primary center-block" onclick="window.print()"><i class="fa-solid fa-print"></i></button>
                    </span>
                    <button type="button" class="btn btn-close" onclick="window.location.href='../cadastros/quadro-de-avisos'"></button>

                </div>
            </form>
        </nav>
    </header>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.mask.min.js"></script>
    <script type="text/javascript">
        function toggleMenu() {
            let navigation = document.querySelector('.navigation');
            let toggle = document.querySelector('.toggle');
            navigation.classList.toggle('active');
            toggle.classList.toggle('active');
        }
    </script>

    <script>
        function listarAvisos() {

            const dataAtual = document.getElementById("data_fim").value;
            const dataInicio = document.getElementById("data_ini").value;

            $.ajax({
                url: '../consultas/printquadrodeavisos.php',
                type: 'POST',
                data: {
                    data_inicio: dataInicio,
                    data_final: dataAtual
                },
                success: function(data) {
                    $(".table_rp").html(data);
                    //$("#sub_titulo").html("Período de: " + dataInicio + " a " + dataAtual);
                }
            })
        }
    </script>