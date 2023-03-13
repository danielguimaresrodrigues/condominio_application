<?php

/*session_start();*/

include('../db/verifica_login.php');

if (is_null($_SESSION['cpf'])) {

    header('Location: ../cadastros/personaldata');
    exit;
}

include('../db/conexao.php');

$id = (int)$_SESSION['id_emp'];
$id_usuario = $_SESSION['id_user_log'];
$result_empresa = "SELECT * FROM empresa WHERE id = '$id' AND ativo='1' LIMIT 1";
$resultado_empresa = mysqli_query($conexao, $result_empresa);
$row_empresa = mysqli_fetch_assoc($resultado_empresa);

$result_config = "SELECT * FROM configuracoes WHERE id_usuario = '$id_usuario'";
$resultado_config = mysqli_query($conexao, $result_config);
$row_config = mysqli_fetch_assoc($resultado_config);

$_SESSION['itens_pag'] = $row_config['itens_pag'];

$result_financ = "SELECT count(*) as total FROM financeiro WHERE id_empresa = '$id' ORDER BY updated_at DESC";
$resultado_financ = mysqli_query($conexao, $result_financ);
$row_financ = mysqli_fetch_assoc($resultado_financ);

$endereco = $row_empresa['rua'] . ", " . $row_empresa['numero'] . ", " . $row_empresa['bairro'] . ", "
    . $row_empresa['cidade'] . "-" . $row_empresa['uf'];

$cep = substr($row_empresa['cep'], 0, 2) . "." . substr($row_empresa['cep'], 2, 3) . "-" . substr($row_empresa['cep'], 5, 3);

$result_entradas = "SELECT SUM(valor) AS total_entradas FROM financeiro WHERE id_empresa = '$id' AND tipo = 'E'";
$resultado_entradas = mysqli_query($conexao, $result_entradas);
while ($rows_entrada = mysqli_fetch_assoc($resultado_entradas)) {
    $soma_entrada = $rows_entrada['total_entradas'];
}

$result_saidas = "SELECT SUM(valor) AS total_saidas FROM financeiro WHERE id_empresa = '$id' AND tipo = 'S'";
$resultado_saidas = mysqli_query($conexao, $result_saidas);
while ($rows_saidas = mysqli_fetch_assoc($resultado_saidas)) {
    $soma_saidas = $rows_saidas['total_saidas'];
}

$result_verif = "SELECT SUM(valor) AS total_verif FROM entradas";
$resultado_verif = mysqli_query($conexao, $result_verif);
while ($rows_verif = mysqli_fetch_assoc($resultado_verif)) {
    $soma_verif = $rows_verif['total_verif'];
}

$saldo_total = $soma_entrada - $soma_saidas;
$soma_entrada = str_replace('.', ',', $soma_entrada);
$soma_saidas = str_replace('.', ',', $soma_saidas);
$saldo_total = str_replace('.', ',', $saldo_total);

$_SESSION['saldo'] = "R$ " . $saldo_total;
$_SESSION['saidas'] = "R$ " . $soma_saidas;
$_SESSION['entradas'] = "R$ " . $soma_entrada;

?>

<?php
include '../templates/header.php';
?>

<body>

    <?php
    include '../templates/basico.php';
    ?>

    <section class="vw-100">
        <div class="container-fluid px-2 py-1" id="fundo">
            <div class="col-sm-9 mx-auto bg-white border border-secondary shadow-sm rounded-3 px-2 py-1 align-self-center">
                <p class="nome_cond text-center py-2"><span style="font-weight: bold;"><?php echo $row_empresa['nome']; ?></span> | <?php echo $row_empresa['email']; ?></p>
            </div>
        </div>
        <div class="container-fluid mt-1">
            <div class="col-sm-9 mx-auto px-3 border border-secondary bg-light shadow rounded-3 align-self-center">
                <p class=" fs-4 ms-3 py-2 text-secondary">Financeiro do Condomínio - Recebidos e pagos</p>

                <div class="row px-2 pb-3 justify-content-center gap-3">
                    <!--div class="col-sm-9 p-4 border bg-light shadow-sm rounded-3 align-items-center">
                        <div class="d-flex justify-content-between px-4 border-bottom">

                        </div>
                    </div-->

                    <div class="col-sm-3 my-1 p-4 border border-primary bg-light shadow rounded-3">
                        <div class="d-flex justify-content-between px-4 border-bottom">
                            <p class=" my-auto">Entradas</p><i class="bi bi-arrow-up-circle my-auto text-success" style="font-size: 1.6rem;"></i>
                        </div>
                        <div class="text-center align-items-center">
                            <h3 class="fw-bold my-2">R$ <?php echo $soma_entrada ?></h3>
                        </div>
                    </div>

                    <div class="col-sm-3 my-1 p-4 border border-primary bg-light shadow rounded-3">
                        <div class="d-flex justify-content-between px-4 border-bottom">
                            <p class=" my-auto">Saídas</p><i class="bi bi-arrow-down-circle my-auto text-danger" style="font-size: 1.6rem;"></i>
                        </div>
                        <div class="text-center align-items-center">
                            <h3 class="fw-bold my-2">R$ <?php echo $soma_saidas ?></h3>
                        </div>
                    </div>

                    <div class="col-sm-3 my-1 p-4 border border-primary bg-light shadow rounded-3">
                        <div class="d-flex justify-content-between px-4 border-bottom">
                            <p>Saldo</p><i class="fa-solid fa-hand-holding-dollar ms-1 text-primary" style="font-size: 1.6rem;"></i>
                        </div>
                        <div class="text-center align-items-center">
                            <h3 class="fw-bold my-2">R$ <?php echo $saldo_total ?></h3>
                        </div>
                    </div>

                </div>
                <ul class="nav nav-tabs no_print">
                    <li class="nav-item">
                        <a class="nav-link active">Recebido / Pago</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pagamentosfuturos">A Pagar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="recebimentosfuturos" aria-current="page">A Receber</a>
                    </li>
                    <!--li class="nav-item">
                        <a class="nav-link" href="">Inadimplência</a>
                    </li-->
                </ul>
                <div class="mx-3 mt-4">
                    <form class="row mb-3 px-3 gap-3 no_print" name="meu-form" action="../edits/alteraconfig.php" method="POST">
                        <div class="row d-grid gap-1 d-flex justify-content-between">
                            <div class="col-md-4 d-grid gap-2 d-flex">
                                <?php if ($_SESSION['perfil'] === '0' || $_SESSION['perfil'] === '1' || $_SESSION['perfil'] === '2') { ?>
                                    <span class="no_print" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Lançamento Unitário">
                                        <button type="button" class="btn btn-sm btn-outline-primary center-block px-5" id="add" data-bs-toggle="modal" data-bs-target="#modal-adicionar" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente"><i class='bi bi-plus-circle' style="font-size: 1.2rem;"></i></button>
                                    </span>
                                    <span class="no_print" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Lançamento em Grupos">
                                        <button type="button" class="btn btn-sm btn-outline-primary center-block px-5" id="add" data-bs-toggle="modal" data-bs-target="#modal-add-grupo" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente"><i class="bi bi-stack" style="font-size: 1.2rem;"></i></button>
                                    </span>
                                <?php } else { ?>
                                    <span class="no_print" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Lançamento Unitário">
                                        <button type="button" class="btn btn-sm btn-outline-primary center-block px-5" id="add" data-bs-toggle="modal" data-bs-target="#modal-adicionar" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente" disabled><i class='bi bi-plus-circle' style="font-size: 1.2rem;"></i></button>
                                    </span>
                                    <span class="no_print" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Lançamento em Grupos">
                                        <button type="button" class="btn btn-sm btn-outline-primary center-block px-5" id="add" data-bs-toggle="modal" data-bs-target="#modal-add-grupo" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente" disabled><i class="bi bi-stack" style="font-size: 1.2rem;"></i></button>
                                    </span>
                                <?php } ?>
                                <!--span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Upload de planilha">
                                    <button type="button" class="btn btn-sm btn-outline-primary center-block px-2" id="add_csv" data-bs-toggle="modal" data-bs-target="#modal-upload-csv" data-bs-trigger="hover focus" data-bs-content="Fazer upload de dados"><i class="fa-solid fa-arrow-up-from-bracket"></i></button>
                                </span-->
                                <span>
                                    <button type="button" class="btn btn-sm btn-outline-primary center-block px-5" id="add_csv" onclick="window.location.href='../consultas/relatorio-de-arrecadacoes'"><i class="bi bi-printer-fill" style="font-size: 1.2rem;"></i></button>
                                </span>
                            </div>

                            <div class="d-flex gap-1 col-md-3 offset-md-3">
                                <p class="fs-6">Mostrar </p>
                                <input type="hidden" name="tela" value="arrecadacoes">
                                <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Digite o número e pressione 'Enter'">
                                    <input class="form-control form-control-sm" type="number" min="1" max="3000" value="<?php echo $_SESSION['itens_pag']; ?>" name="itens_pag" id="itens_pag" placeholder="Linhas" style="width: auto;">
                                </span>

                                <p class="fs-6">linhas</p>
                            </div>
                            <!--div class="col">
                                <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Data Inicial(venc.)">
                                    <input class="form-control  form-control-sm" type="date" name="data_ini" id="data_ini" placeholder="Data" required>
                                </span>
                            </div>
                            <div class="col">
                                <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Data Final(venc.)">
                                    <input class="form-control  form-control-sm" type="date" name="data_fim" id="data_fim" placeholder="Data" required>
                                </span>
                            </div>
                            <div class="col">
                                <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Filtrar">
                                    <button type="button" class="btn btn-sm btn-outline-primary center-block" id="filtrar" onclick="listarRecebidosPagos()"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    <input class="form-control  form-control-sm" type="text" name="pagina" id="pagina" placeholder="Página">
                                </span>
                            </div-->
                        </div>
                    </form>
                    <form class="row mb-3 px-3 gap-3" name="meu-form" action="" method="POST">
                        <!--p class="col-sm-6">* Total de 6 blocos por condomínio.</p-->
                        <?php
                        if (isset($_SESSION['cadastro_arrecadacao'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Parabéns!", "Lançamento efetuado!", "success");
                            </script-->
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Lançamento efetuado com sucesso!',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>
                        <?php
                        endif;
                        unset($_SESSION['cadastro_arrecadacao']);
                        ?>
                        <script type="text/javascript">
                            document.addEventListener('DOMContentLoaded', function() {
                                setTimeout(function() {
                                    $("#msg_sucesso").fadeOut().empty();
                                }, 6000);
                            }, false);
                        </script>

                        <?php
                        if (isset($_SESSION['financeiro_upload'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Parabéns!", "Lançamento efetuado!", "success");
                            </script-->
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Upload efetuado com sucesso!',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>
                        <?php
                        endif;
                        unset($_SESSION['financeiro_upload']);
                        ?>

                        <?php
                        if (isset($_SESSION['nao_alterou'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Parabéns!", "Lançamento alterado com sucesso!", "success");
                            </script-->
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Lançamento alterado com sucesso!',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>
                        <?php
                        endif;
                        unset($_SESSION['nao_alterou']);
                        ?>
                        <script type="text/javascript">
                            document.addEventListener('DOMContentLoaded', function() {
                                setTimeout(function() {
                                    $("#msg_sucesso").fadeOut().empty();
                                }, 6000);
                            }, false);
                        </script>

                        <?php
                        if (isset($_SESSION['financeiro_upload_fail'])) {
                        ?>
                            <!--script type="text/javascript">
                                swal("Aviso!", "Lançamento exlcuído com sucesso!", "success");
                            </script-->
                            <script>
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Escolha somente arquivos pdf ou jpg!',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>
                        <?php
                        }
                        unset($_SESSION['financeiro_upload_fail']);
                        ?>

                        <?php
                        if (isset($_SESSION['financeiro_upload_size'])) :
                        ?>
                            <script>
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Tamanho máximo do arquivo deve ser de 5MB!',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>

                        <?php

                        endif;
                        unset($_SESSION['financeiro_upload_size']);
                        ?>

                        <?php
                        if (isset($_SESSION['status_deletagrupo'])) :
                        ?>
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Lançamento excluído com sucesso!',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>

                        <?php

                        endif;
                        unset($_SESSION['status_deletagrupo']);
                        ?>
                    </form>
                </div>
                <div id="table_rp">
                    <?php
                    //receber o número da página
                    $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);

                    $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

                    //setar a quantidade de itens por página
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        //$qtd_result_pg = $qtd_pgs_pagina;
                        //$_SESSION['qtd_pgs_pagina'] = $qtd_pgs_pagina;
                    } else {
                    }

                    $qtd_result_pg = $_SESSION['itens_pag'];
                    //calcular o início da visualização
                    $inicio = ($qtd_result_pg * $pagina) - $qtd_result_pg;

                    $result_financeiro = "SELECT * FROM financeiro WHERE id_empresa = '$id' AND tipo IN ('E', 'S') ORDER BY datavenc_at DESC LIMIT $inicio, $qtd_result_pg";
                    $resultado_financeiro = mysqli_query($conexao, $result_financeiro);
                    $row_financeiro = mysqli_num_rows($resultado_financeiro);
                    if ($row_financeiro != 0) : ?>
                        <div class="scroll">
                            <table class="table table-hover table-bordered">
                                <thead class="table-primary border-bottom">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th class="d-none">ID Grupo</th>
                                        <th style="width: 20%;">Categoria</th>
                                        <th style="width: 30%;">Descrição</th>
                                        <th class="d-none">ID Unidade</th>
                                        <th style="width: 10%;">Unidade</th>
                                        <th class="d-none">ID Bloco</th>
                                        <th style="width: 10%;">Bloco</th>
                                        <th style="width: 15%">Valor</th>
                                        <th style="width: 15%">Data Venc.</th>
                                        <th class=" text-center" style="width: 5%;">Tipo</th>
                                        <th class="no_print" style="width: 5%;"><i class="bi bi-paperclip"></i></th>
                                        <?php if ($_SESSION['perfil'] === '0' || $_SESSION['perfil'] === '1' || $_SESSION['perfil'] === '2') { ?>
                                            <th class="no_print" style="width: 5%;"></th>
                                            <th class="no_print" style="width: 5%;"></th>
                                        <?php } ?>
                                        <!--th scope="col"></th-->
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    <?php
                                    while ($row_financeiro = mysqli_fetch_assoc($resultado_financeiro)) {
                                    ?>
                                        <tr>
                                            <?php $taxa = $row_financeiro['valor'];
                                            $taxa = str_replace('.', ',', $taxa);
                                            $taxa = "R$ " . $taxa;
                                            $datavenc = implode("/", array_reverse(explode("-", $row_financeiro['datavenc_at'])));

                                            if ($row_financeiro['tipo'] === "E") {
                                                $tippo = "Recebido";
                                            } elseif ($row_financeiro['tipo'] === "D") {
                                                $tippo = "A pagar";
                                            } elseif ($row_financeiro['tipo'] === "P") {
                                                $tippo = "A receber";
                                            } elseif ($row_financeiro['tipo'] === "S") {
                                                $tippo = "Pago";
                                            }
                                            ?>
                                            <td class="fs-6" id="id<?php echo $row_financeiro['id']; ?>"><?php echo $row_financeiro['id']; ?></td>
                                            <td class="fs-6 d-none" id="idgrupo<?php echo $row_financeiro['id']; ?>"><?php echo $row_financeiro['id_grupo']; ?></td>
                                            <td class="fs-6" id="ed_grupo<?php echo $row_financeiro['id']; ?>"><?php echo $row_financeiro['grupo']; ?></td>
                                            <td class="fs-6" id="ed_descricao<?php echo $row_financeiro['id']; ?>"><?php echo $row_financeiro['descricao']; ?></td>
                                            <td class="fs-6 d-none" id="ed_idunidade<?php echo $row_financeiro['id']; ?>"><?php echo $row_financeiro['id_unidade']; ?></td>
                                            <td class="fs-6" id="ed_unidade<?php echo $row_financeiro['id']; ?>"><?php echo $row_financeiro['unidade']; ?></td>
                                            <td class="fs-6 d-none" id="ed_idbloco<?php echo $row_financeiro['id']; ?>"><?php echo $row_financeiro['id_bloco']; ?></td>
                                            <td class="fs-6" id="ed_bloco<?php echo $row_financeiro['id']; ?>"><?php echo $row_financeiro['bloco']; ?></td>
                                            <td class="fs-6" id="ed_valorr<?php echo $row_financeiro['id']; ?>"><?php echo str_replace('.', ',', $row_financeiro['valor']); ?></td>
                                            <td class="fs-6" id="ed_datavenc<?php echo $row_financeiro['id']; ?>"><?php echo $datavenc; ?></td>
                                            <td class="fs-6 d-none" id="descricao_edits<?php echo $row_financeiro['id']; ?>"><?php echo $row_financeiro['descricao']; ?></td>
                                            <td class="fs-6 d-none" id="tipo_edits<?php echo $row_financeiro['id']; ?>"><?php echo $tippo; ?></td>
                                            <?php if ($row_financeiro['tipo'] === "E") : ?>
                                                <td><i class="bi bi-arrow-up-circle ms-1 text-success text-center" style="font-size: 1.3rem;"></i></td>
                                            <?php elseif ($row_financeiro['tipo'] === "S") : ?>
                                                <td><i class="bi bi-arrow-down-circle ms-1" style="font-size: 1.3rem; color:brown;"></i></td>
                                            <?php elseif ($row_financeiro['tipo'] === "D") : ?>
                                                <td><i class="bi bi-arrow-down-circle ms-1 text-warning" style="font-size: 1.3rem;"></i></td>
                                            <?php elseif ($row_financeiro['tipo'] === "P") : ?>
                                                <td><i class="bi bi-arrow-up-circle ms-1 text-warning text-center" style="font-size: 1.3rem;"></i></td>
                                            <?php endif; ?>
                                            <?php if (is_null($row_financeiro['documento'])) { ?>
                                                <td>
                                                    <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Upload de comprovante">
                                                        <button type="button" class="btn btn-sm btn-primary" id="botao_upload" onclick="uploadArq(<?php echo $row_financeiro['id']; ?>)" data-bs-toggle="modal" data-bs-target="#modal_file" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente"><i class="bi bi-cloud-arrow-up"></i></button>
                                                    </span>
                                                </td>
                                            <?php } else { ?>
                                                <td>
                                                    <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Abrir comprovante">
                                                        <a type="button" class="btn btn-sm btn-outline-primary" id="botao_upload" href='../assets/comprovantes/<?php echo $row_financeiro['documento']; ?>' target="_blank" data-bs-toggle="modal" data-bs-target="" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente"><i class="bi bi-eye-fill"></i></a>
                                                    </span>
                                                </td>
                                            <?php } ?>
                                            <?php if ($_SESSION['perfil'] === '0' || $_SESSION['perfil'] === '1' || $_SESSION['perfil'] === '2') { ?>
                                                <td>
                                                    <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Editar lançamento">
                                                        <button type="button" class="btn btn-sm btn-outline-primary" id="botao_editar" onclick="editar_registro(<?php echo $row_financeiro['id']; ?>)" data-bs-toggle="modal" data-bs-target="#modal-edit" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente"><i class='bi bi-pencil-fill'></i></button>
                                                        <!--button type="button" class="btn btn-sm btn-outline-primary center-block" id="botao_salvar" style="display: none;"><i class="fa fa-floppy-disk"></i></button-->
                                                    </span>
                                                </td>
                                                <td>
                                                    <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Excluir lançamento.">
                                                        <!--?php echo "<a class='btn btn-outline-danger btn-sm center-block' href='editcolaboradores.php?id=" . $row_empresa['id'] . "'><i class='fa fa-trash'></i></a>"; ?-->
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="exclui_registro(<?php echo $row_financeiro['id']; ?>)" data-bs-toggle="modal" data-bs-target="#exclui_lancamento" data-bs-trigger="hover focus" data-bs-content="Excluir lançamento"><i class='bi bi-trash-fill'></i></button>
                                                    </span>
                                                </td>
                                            <?php } ?>
                                            <!--td>
                                                <div class="dropdown me-1">
                                                    <button type="button" class="btn btn-secondary" id="dropdownMenuOffset" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="10,20">
                                                        ...
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                            </td-->
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--?php endif; ?-->
                        </div>
                        <!--div class="container-fluid px-2 pb-1" id="fundo"-->
                        <div class="col-sm-12 mx-auto bg-white text-center px-2 mb-3 pb-2 align-self-center">
                            <?php
                            //Paginação - somar a qtd de itens
                            $result_pg = "SELECT COUNT(id) AS num_result FROM financeiro WHERE id_empresa = '$id' AND tipo IN ('E', 'S')";
                            $resultado_pg = mysqli_query($conexao, $result_pg);
                            $row_pg = mysqli_fetch_assoc($resultado_pg);
                            //echo $row_pg['num_result'];
                            //qtd de páginas

                            $quantidade_pg = ceil($row_pg['num_result'] / $qtd_result_pg); ?>
                            <?php if ($pagina_atual != '') { ?>
                                <p class="fs-6 text-center">Página <?php echo $pagina_atual ?> de <?php echo $quantidade_pg ?> | Total de registros <?php echo $row_pg['num_result']; ?></p>
                            <?php } else { ?>
                                <p class="fs-6 text-center">Página 1 de <?php echo $quantidade_pg ?> | Total de registros <?php echo $row_pg['num_result']; ?></p>
                            <?php } ?>
                            <?php if ($row_pg['num_result'] > $qtd_result_pg) {
                                //limitar o link antes e depois
                                $max_links = 2;
                                echo "<a class='btn btn-sm btn-outline-primary mx-1' href='arrecadacoes?pagina=1'><i class='fas fa-angle-left'></i></a>";
                                for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                                    if ($pag_ant >= 1) {
                                        echo "<a class='btn btn-sm btn-outline-primary mx-1' href='arrecadacoes?pagina=$pag_ant' disabled>$pag_ant</a>";
                                    }
                                }
                                echo "<button type='button' class='btn btn-sm btn-outline-primary mx-1' disabled>$pagina</button>";
                                for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                                    if ($pag_dep <= $quantidade_pg) {
                                        echo "<a class='btn btn-sm btn-outline-primary mx-1' href='arrecadacoes?pagina=$pag_dep'>$pag_dep</a>";
                                    }
                                }
                                echo "<a class='btn btn-sm btn-outline-primary mx-1' href='arrecadacoes?pagina=$quantidade_pg'><i class='fas fa-angle-right'></i></a>";
                            }
                            //$conexao->close();
                            ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Editar Lançamento</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../edits/alteralancamento.php" method="POST">
                        <div class="row px-3">

                            <div class="form-floating mb-3">
                                <input class="form-control" type="hidden" name="id_edits" id="id_edits" required readonly>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="nome">Grupo</label>
                                <input class="form-control" type="text" name="grupo_edits" id="grupo_edits" placeholder="Digite o grupo" required readonly>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="nome">Bloco</label>
                                <input class="form-control" type="text" name="bloco_edits" id="bloco_edits" placeholder="Digite o bloco" required readonly>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="nome">Unidade</label>
                                <input class="form-control" type="text" name="unidade_edits" id="unidade_edits" placeholder="Digite a unidade" required readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="nome">Valor</label>
                                <input class="form-control" type="text" name="valor_edits" id="valor_edits" placeholder="Digite o valor" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome">Data</label>
                                <input class="form-control" type="text" name="data_edits" id="data_edits" placeholder="Data" required readonly>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome">Tipo</label>
                                <input class="form-control" type="text" name="tipo_edits" id="tipo_edits" placeholder="Tipo" required readonly>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="nome">Descrição</label>
                                <textarea class="form-control" name="descricao_edits" id="descricao_edits" placeholder="(Opcional)" style="height: 10vh;" maxlength="300"></textarea>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="col-md-3 m-2">
                                    <button type="submit" name="salva" id="salva" class="btn btn-outline-primary">Salvar</button>
                                </div>
                                <div class="col-md-3 m-2">
                                    <button type="button" id="volta" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-adicionar">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Receber / Pagar</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../edits/addpagamentos.php" method="POST">
                        <div class="row px-3">

                            <div class="form-floating mb-3">
                                <input class="form-control" type="hidden" value='<?php echo $_SESSION['id_emp']; ?>' name="id_empresa" id="id_empresa" required readonly>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="nome">Categoria</label>
                                <select class="form-select fw-light" name="grupo_adds" id="grupo_adds" required>
                                    <option value="">Selecione a categoria</option>
                                    <?php
                                    $result_grupo = "SELECT * FROM grupos WHERE id_empresa = '$id' AND ativo='1' ORDER BY grupo";
                                    $resultado_grupos = mysqli_query($conexao, $result_grupo);
                                    while ($row_grupos = mysqli_fetch_assoc($resultado_grupos)) { ?>
                                        <option value="<?php echo $row_grupos['id'] . '|' . $row_grupos['grupo']; ?>"><?php echo $row_grupos['grupo']; ?></option>
                                        <!--?php echo $row_blocoss['id'] . '|' . $row_blocoss['bloco']; ?-->
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="nome">Bloco</label>
                                <select class="form-select fw-light" name="bloco_adds" id="bloco_adds" required>
                                    <option value="">Selecione o Bloco</option>
                                    <?php
                                    $result_blocos = "SELECT * FROM blocos WHERE id_empresa = '$id' AND ativo='1'";
                                    $resultado_blocos = mysqli_query($conexao, $result_blocos);
                                    while ($row_blocos = mysqli_fetch_assoc($resultado_blocos)) { ?>
                                        <option value="<?php echo $row_blocos['id'] . '|' . $row_blocos['bloco']; ?>"><?php echo $row_blocos['bloco']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="nome">Unidade</label>
                                <select class="form-select fw-light" name="unidade_adds" id="unidade_adds" required>
                                    <option value="">Selecione um item</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="nome">Valor</label>
                                <input class="form-control" type="text" name="valor_adds" id="moeda" placeholder="Digite o valor" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome">Data Venc.</label>
                                <input class="form-control" type="date" name="data_adds" id="data_adds" placeholder="Data" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome">Tipo</label>
                                <select class="form-select fw-light" name="tipo_adds" id="tipo_adds">
                                    <option value="E">Recebido</option>
                                    <option value="D">A pagar</option>
                                    <option value="P">A receber</option>
                                    <option value="S">Pago</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="nome">Descrição</label>
                                <textarea class="form-control" name="descricao_adds" id="descricao_adds" placeholder="(Opcional)" style="height: 10vh;" maxlength="300"></textarea>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="col-md-3 m-2">
                                    <button type="submit" name="salva" id="salva" class="btn btn-outline-primary">Salvar</button>
                                </div>
                                <div class="col-md-3 m-2">
                                    <button type="button" id="volta" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-add-grupo">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Receber / Pagar em Grupo</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form class="form-signin" id="register-form" action="../edits/addpagamentosgroup.php" method="POST">
                        <div class="row px-3">
                            <div class="col-sm-12 mx-auto bg-white border border-secondary rounded-3 px-2 py-2 align-self-center">
                                <div class="row">
                                    <div class="col-sm-3 mb-3">
                                        <label for="nome">Bloco</label>
                                        <select class="form-select fw-light" name="bloco_adds_group" id="bloco_adds_group" required>
                                            <option value="0|0">Selecione o bloco</option>
                                            <?php
                                            $result_blocos = "SELECT * FROM blocos WHERE id_empresa = '$id' AND ativo='1'";
                                            $resultado_blocos = mysqli_query($conexao, $result_blocos);
                                            while ($row_blocos = mysqli_fetch_assoc($resultado_blocos)) { ?>
                                                <option value="<?php echo $row_blocos['id'] . '|' . $row_blocos['bloco']; ?>"><?php echo $row_blocos['bloco']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <input class="form-control  col-sm-6" type="hidden" name="unidades_adds_group" id="unidades_adds_group" placeholder="Selecione as unidades" required>

                                    <div class="mb-3 col-md-8" id="result_unidades">
                                        <!--label for="nome">Unidades</label>
                                        <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Conforme grupo selecionado.">
                                        <div class="input-group" id="result_unidades"-->
                                        <!--input class="form-control  col-sm-6" type="text" name="unidades_adds_group" id="unidades_adds_group" placeholder="Selecione as unidades" required readonly>

                                                <a class="btnbtn btn-sm btn-primary" id="open_modal"><i class="fa fa-search"></i></a>

                                    </div-->
                                        <!--/span-->
                                    </div>
                                    <!--div class="mb-1 col-md-2 overflow-auto border border-primary p-2" style="height: 25vh;">
                                        <table class="table table-hover table-striped">
                                            <thead class="table-primary border-bottom">
                                                <tr>
                                                    <th style="width: 3%;"></th>
                                                    <th class="d-none">ID</th>
                                                    <th scope="col">Unidade</th>
                                                </tr>
                                            </thead>
                                            <tbody id="unidade_adds_group">

                                            </tbody>
                                        </table>
                                    </div-->

                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" type="hidden" value='<?php echo $_SESSION['id_emp']; ?>' name="id_empresa_group" id="id_empresa_group" required readonly>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="nome">Categoria</label>
                                <select class="form-select fw-light" name="grupo_adds_group" id="grupo_adds_group" required>
                                    <option value="">Selecione a Categoria</option>
                                    <?php
                                    $result_grupo = "SELECT * FROM grupos WHERE id_empresa = '$id' AND ativo='1' ORDER BY grupo";
                                    $resultado_grupos = mysqli_query($conexao, $result_grupo);
                                    while ($row_grupos = mysqli_fetch_assoc($resultado_grupos)) { ?>
                                        <option value="<?php echo $row_grupos['id'] . '|' . $row_grupos['grupo']; ?>"><?php echo $row_grupos['grupo']; ?></option>
                                        <!--?php echo $row_blocoss['id'] . '|' . $row_blocoss['bloco']; ?-->
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="nome">Valor</label>
                                <input class="form-control" type="text" name="valor_adds_group" id="valor_adds_group" placeholder="Digite o valor" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome">Data Venc.</label>
                                <input class="form-control" type="date" name="data_adds_group" id="data_adds_group" placeholder="Data" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome">Tipo</label>
                                <select class="form-select fw-light" name="tipo_adds_group" id="tipo_adds_group">
                                    <option value="E">Recebido</option>
                                    <option value="D">A pagar</option>
                                    <option value="P">A receber</option>
                                    <option value="S">Pago</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-9">
                                <label for="nome">Descrição</label>
                                <textarea class="form-control" name="descricao_adds_group" id="descricao_adds_group" placeholder="(Opcional)" style="height: 10vh;" maxlength="300"></textarea>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="col-md-3 m-2">
                                    <button type="submit" name="salva" id="salva" class="btn btn-outline-primary">Salvar</button>
                                </div>
                                <div class="col-md-3 m-2">
                                    <button type="button" id="volta" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exclui_lancamento">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Exclusão de Lançamento</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="fs-5 text-secondary fw-light mx-5">Confirma a exclusão do Lançamento?</p>

                    <form action="../edits/excluilancamento.php" method="POST">
                        <div class="row px-3">
                            <div class="form-floating mb-3">
                                <input type="hidden" name="id_financeiro_trash" class="form-control" placeholder="ID" id="id_financeiro_trash">
                            </div>
                            <div class="mb-3 col-md-3">
                                <input class="form-control" type="hidden" name="tipo_edits_excluir" id="tipo_edits_excluir" placeholder="Tipo" required readonly>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="col-md-3 m-2">
                                    <button type="submit" id="salva" name="salva" class="btn btn-danger">Confirma</button>
                                </div>
                                <div class="col-md-3 m-2">
                                    <button type="button" id="volta" name="volta" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_file">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Upload de comprovante</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!--p class="fs-5 text-secondary fw-light mx-5">Confirma a exclusão do Lançamento?</p-->

                    <form action="../edits/uploaddedocumentos.php" method="POST" enctype="multipart/form-data">
                        <input class="form-control" type="hidden" name="id_financeiro_upload" id="id_financeiro_upload" required readonly>
                        <input class="form-control" type="hidden" name="novo_nome" id="novo_nome" required readonly>
                        <div class="row px-3">
                            <div class="mb-3 col-md-12">
                                <input class="form-control" type="file" name="arquivo" id="arquivo" placeholder="Upload de comprovante" required readonly>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="col-md-3 m-2">
                                    <button type="submit" id="salva" name="salva" class="btn btn-danger">Confirma</button>
                                </div>
                                <div class="col-md-3 m-2">
                                    <button type="button" id="volta" name="volta" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-5 hide" id="fade"></div>
    <div class="col-sm-4 mx-auto p-3 border border-secondary bg-light shadow rounded-3 align-self-center hide" id="modal">
        <div class="modal_header">
            <h5>Selecione as Unidades</h5>
            <button class="btn-close" id="close_modal"></button>
        </div>
        <div class="modal_body col-sm-12">
            <div class="mb-1 col-md-12 overflow-auto border border-primary" style="height: 25vh;">
                <table class="table table-hover table-striped" id="tblData">
                    <thead class="table-primary border-bottom">
                        <tr>
                            <th style="width: 3%;"></th>
                            <th class="d-none">ID</th>
                            <th scope="col">Unidade</th>
                        </tr>
                    </thead>
                    <tbody id="unidade_adds_group">
                        <td class="d-none">-</td>
                        <td>-</td>
                        <td>Selecione um grupo ao lado.</td>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="footer_modal">
            <div class="d-flex justify-content-center">
                <div class="col-md-3 m-2">
                    <button type="button" id="salva" name="confirma" class="btn btn-danger" onclick="selecionaCheck();">Confirma</button>
                </div>
                <div class="col-md-3 m-2">
                    <button type="button" id="voltar" name="volta" class="btn btn-outline-secondary">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <?php $conexao->close(); ?>
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>

    <script>
        var numb = document.forms['meu-form']['num_blocos'];

        function validatio_bloc() {
            if (numb.value == '') {
                alert("Número de blocos não pode ser vazio");
                return false;
            }
            if (numb.value > 6) {
                document.getElementById("num_blocos").value = 6;
                return false;
            }
            if (numb.value < 1) {
                document.getElementById("num_blocos").value = 1;
                return false;
            }

            return true;
        }
    </script>

    <script>
        function editar_registro(id) {
            // Ocultar o botao editar
            //document.getElementById("botao_editar" + id).style.display = "none";
            //console.log("Acessou: " + id);
            // Apresentar o botao salvar
            //document.getElementById("botao_salvar" + id).style.display = "block";

            // Recuperar os valores do registro que esta na tabela
            var grupo = document.getElementById("ed_grupo" + id);
            var bloco = document.getElementById("ed_bloco" + id);
            var ed_valorr = document.getElementById("ed_valorr" + id);
            var unidade_edits = document.getElementById("ed_unidade" + id);
            var ed_datavenc = document.getElementById("ed_datavenc" + id);
            var descricao_edits = document.getElementById("descricao_edits" + id);
            var tipo_edits = document.getElementById("tipo_edits" + id);

            document.getElementById("grupo_edits").value = grupo.innerHTML;
            document.getElementById("bloco_edits").value = bloco.innerHTML;
            document.getElementById("unidade_edits").value = unidade_edits.innerHTML;
            document.getElementById("valor_edits").value = ed_valorr.innerHTML;
            document.getElementById("data_edits").value = ed_datavenc.innerHTML;
            document.getElementById("descricao_edits").value = descricao_edits.innerHTML;
            document.getElementById("tipo_edits").value = tipo_edits.innerHTML;
            document.getElementById("id_edits").value = id;
        }

        function exclui_registro(id) {
            document.getElementById("id_financeiro_trash").value = id;
            var tipo_edits_excluir = document.getElementById("tipo_edits" + id);
            document.getElementById("tipo_edits_excluir").value = tipo_edits_excluir.innerHTML;
        }

        function uploadArq(id) {
            document.getElementById("id_financeiro_upload").value = id;
            var grupo = document.getElementById("ed_grupo" + id);
            var bloco = document.getElementById("ed_bloco" + id);
            var unidade = document.getElementById("ed_unidade" + id);

            //var novo_nome = str(id, grupo, bloco, unidade);

            document.getElementById("novo_nome").value = id + 'comprovante' + grupo.innerHTML + bloco.innerHTML + unidade.innerHTML;
        }
    </script>

    <script>
        function listar() {
            //$('#tblData tr').each(function() {
            //  let check = $(this).find('#check_unidade_group').is(':checked'); //true ou false
            //let unidade_group = $(this).find('td').eq(2).text();
            //if (check) {
            //  var textunidades = "<input class='form-control  col-sm-6' type='text' name='unidades_adds_group' value='" + unidade_group + "' id='unidades_adds_group' placeholder='Selecione as unidades' required readonly>";
            //$('#unidades_adds_group').html(textunidades);
            //}
            //});

            let unidadess = document.getElementsByName("unidades_groupp");
            let unidadesSelecionadas = [];

            for (var i = 0; i < unidadess.length; i++) {
                if (unidadess[i].checked) {
                    unidadesSelecionadas.push(unidadess[i].value);
                }
            }
            document.getElementById('unidades_adds_group').value = unidadesSelecionadas.toString();
        }
    </script>

    <!--script type="text/javascript">
        $(document).ready(function() {
            listarRecebidosPagos()
        });
    </script-->

    <script>
        $("#bloco_adds").on("change", function() {
            var blocoss = $("#bloco_adds").val();
            blocoss = blocoss.split("|", 2);

            $.ajax({
                url: '../consultas/listarunidade.php',
                type: 'POST',
                data: {
                    bloco: blocoss[1]
                },
                success: function(data) {
                    $("#unidade_adds").html(data);
                }
            })
        });
    </script>

    <script type="text/javascript">
        VirtualSelect.init({
            ele: '#unidade_adds_group'
        });
    </script>

    <script>
        $("#bloco_adds_group").on("change", function() {
            var blocoss_group = $("#bloco_adds_group").val();
            blocoss_group = blocoss_group.split("|", 2);

            $.ajax({
                url: '../consultas/listarunidadegroup.php',
                type: 'POST',
                data: {
                    bloco_group: blocoss_group[1]
                },
                success: function(data) {
                    $("#result_unidades").html(data);
                }
            })
        });

        //$("#itens_pag").on("change", function() {
        //  var itens_pag = $("#itens_pag").val();

        //$.ajax({
        //  url: '../edits/alteraconfig.php',
        //type: 'POST',
        //data: {
        //  itens_pag: itens_pag
        //},
        // success: function(data) {
        //   $("#itens_pag").html(data);
        // window.location = "arrecadacoes?pagina=1";
        // }
        // })
        // });
    </script>

    <!--script>

function listarRecebidosPagos() {

            const dataAtual = document.getElementById("data_fim").value;
            const dataInicio = document.getElementById("data_ini").value;

            var total_pg = $("#total_paginas").val();

            $.ajax({
                url: '../consultas/listarecebidospagos.php',
                type: 'POST',
                data: {
                    data_inicio: dataInicio,
                    data_final: dataAtual
                },
                success: function(data) {
                    $("#table_rp").html(data);
                }
            })
        }

        $("#total_paginas").on("change", function() {

            const dataAtual = document.getElementById("data_fim").value;
            const dataInicio = document.getElementById("data_ini").value;

            var total_pg = $("#total_paginas").val();

            $.ajax({
                url: '../consultas/listarecebidospagos.php',
                type: 'POST',
                data: {
                    data_ini: dataInicio,
                    data_fim: dataAtual,
                    total_pg: total_pg
                },
                success: function(data) {
                    $("#table_rp").html(data);
                }
            })
        });
        $("#data_ini").on("change", function() {

            const dataAtual = document.getElementById("data_fim").value;
            const dataInicio = document.getElementById("data_ini").value;

            var total_pg = $("#total_paginas").val();

            $.ajax({
                url: '../consultas/listarecebidospagos.php',
                type: 'POST',
                data: {
                    data_ini: dataInicio,
                    data_fim: dataAtual,
                    total_pg: total_pg
                },
                success: function(data) {
                    $("#table_rp").html(data);
                }
            })
        });
        $("#data_fim").on("change", function() {

            const dataAtual = document.getElementById("data_fim").value;
            const dataInicio = document.getElementById("data_ini").value;

            var total_pg = $("#total_paginas").val();

            $.ajax({
                url: '../consultas/listarecebidospagos.php',
                type: 'POST',
                data: {
                    data_ini: dataInicio,
                    data_fim: dataAtual,
                    total_pg: total_pg
                },
                success: function(data) {
                    $("#table_rp").html(data);
                }
            })
        });
    </script-->

</body>

</html>