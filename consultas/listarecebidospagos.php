 <?php
    session_start();
    include('../db/conexao.php');

    $id = (int)$_SESSION['id_emp'];
    $data_inicial = $_POST['data_inicio'];
    $data_final = $_POST['data_final'];

    $data_inicial = implode("-", array_reverse(explode("/", $data_inicial)));
    $data_final = implode("-", array_reverse(explode("/", $data_final)));
    //receber o número da página
    $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);

    $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
    /*if (@$_POST['pagina'] == "") {
        @$_POST['pagina'] = 1;
    }
    $pagina = intval(@$_POST['pagina']);*/

    //setar a quantidade de itens por página
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //$qtd_result_pg = $qtd_pgs_pagina;
        //$_SESSION['qtd_pgs_pagina'] = $qtd_pgs_pagina;
    } else {
    }

    $qtd_result_pg = $_SESSION['itens_pag'];
    //calcular o início da visualização
    $inicio = ($qtd_result_pg * $pagina) - $qtd_result_pg;

    if (!empty($data_inicial)) {
        $result_financeiro = "SELECT * FROM financeiro WHERE id_empresa = '$id' AND datavenc_at BETWEEN '$data_inicial' AND '$data_final' AND tipo IN ('E', 'S') ORDER BY datavenc_at DESC LIMIT $inicio, $qtd_result_pg";
    } else {
        $result_financeiro = "SELECT * FROM financeiro WHERE id_empresa = '$id' AND tipo IN ('E', 'S') ORDER BY datavenc_at DESC LIMIT $inicio, $qtd_result_pg";
    }
    $resultado_financeiro = mysqli_query($conexao, $result_financeiro);
    $row_financeiro = mysqli_num_rows($resultado_financeiro);
    if ($row_financeiro != 0) {
        echo "<p>Data inicial: " . $data_inicial . "Data final: " . $data_final . "</p>";
        echo "<div class='scroll'>";
        echo "<table class='table table-hover table-striped border-top'>";
        echo "<thead class='table-primary border-bottom'>";
        echo "<tr>";
        echo "<th class='d-none'>ID Grupo</th>";
        echo "<th style='width: 20%;'>Grupo</th>";
        echo "<th style='width: 30%;'>Descrição</th>";
        echo "<th class='d-none'>ID Unidade</th>";
        echo "<th style='width: 10%;'>Unidade</th>";
        echo "<th class='d-none'>ID Bloco</th>";
        echo "<th style='width: 10%;'>Bloco</th>";
        echo "<th style='width: 15%'>Valor</th>";
        echo "<th style='width: 15%'>Data Venc.</th>";
        echo "<th style='width: 5%;'>Tipo</th>";
        echo "<th style='width: 5%;'></th>";
        echo "<th style='width: 5%;'></th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody id='myTable'>";

        while ($row_financeiro = mysqli_fetch_assoc($resultado_financeiro)) {

            echo "<tr>";
            $taxa = $row_financeiro['valor'];
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
            echo "<td class='fs-6 d-none' id='idgrupo" . $row_financeiro['id'] . "'>" . $row_financeiro['id_grupo'] . "</td>";
            echo "<td class='fs-6' id='ed_grupo" . $row_financeiro['id'] . "'>" . $row_financeiro['grupo'] . "</td>";
            echo "<td class='fs-6' id='ed_descricao" . $row_financeiro['id'] . "'>" . $row_financeiro['descricao'] . "</td>";
            echo "<td class='fs-6 d-none' id='ed_idunidade" . $row_financeiro['id'] . "'>" . $row_financeiro['id_unidade'] . "</td>";
            echo "<td class='fs-6' id='ed_unidade" . $row_financeiro['id'] . "'>" . $row_financeiro['unidade'] . "</td>";
            echo "<td class='fs-6 d-none' id='ed_idbloco" . $row_financeiro['id'] . "'>" . $row_financeiro['id_bloco'] . "</td>";
            echo "<td class='fs-6' id='ed_bloco" . $row_financeiro['id'] . "'>" . $row_financeiro['bloco'] . "</td>";
            echo "<td class='fs-6' id='ed_valorr" . $row_financeiro['id'] . "'>" . str_replace('.', ',', $row_financeiro['valor']) . "</td>";
            echo "<td class='fs-6' id='ed_datavenc" . $row_financeiro['id'] . "'>" . $datavenc . "</td>";
            echo "<td class='fs-6 d-none' id='descricao_edits" . $row_financeiro['id'] . "'>" . $row_financeiro['descricao'] . "</td>";
            echo "<td class='fs-6 d-none' id='tipo_edits" . $row_financeiro['id'] . "'>" . $tippo . "</td>";
            if ($row_financeiro['tipo'] === "E") {
                echo "<td><i class='fa-regular fa-circle-up ms-1 text-success' style='font-size: 1.3rem;'></i></td>";
            } elseif ($row_financeiro['tipo'] === "S") {
                echo "<td><i class='fa-regular fa-circle-down ms-1' style='font-size: 1.3rem; color:brown;'></i></td>";
            } elseif ($row_financeiro['tipo'] === "D") {
                echo "<td><i class='fa-regular fa-circle-down ms-1 text-warning' style='font-size: 1.3rem;'></i></td>";
            } elseif ($row_financeiro['tipo'] === "P") {
                echo "<td><i class='fa-regular fa-circle-up ms-1 text-warning' style='font-size: 1.3rem;'></i></td>";
            }
            echo "<td>";
            echo "<span tabindex='0' data-bs-toggle='popover' data-bs-trigger='hover focus' data-bs-content='Editar lançamento'>";
            echo "<button type='button' class='btn btn-sm btn-outline-primary' id='botao_editar' onclick='editar_registro(" . $row_financeiro['id'] . ")' data-bs-toggle='modal' data-bs-target='#modal-edit' data-bs-trigger='hover focus' data-bs-content='Cadastrar cliente'><i class='fa-solid fa-pencil'></i></button>";
            echo "</span>";
            echo "</td>";
            echo "<td>";
            echo "<span tabindex='0' data-bs-toggle='popover' data-bs-trigger='hover focus' data-bs-content='Excluir lançamento.'>";
            echo "<button type='button' class='btn btn-sm btn-outline-danger' onclick='exclui_registro(" . $row_financeiro['id'] . ")' data-bs-toggle='modal' data-bs-target='#exclui_lancamento' data-bs-trigger='hover focus' data-bs-content='Excluir lançamento'><i class='fa fa-trash'></i></button>";
            echo "</span>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "<div class='col-sm-12 mx-auto bg-white text-center px-2 mb-3 pb-2 align-self-center'>";

        //Paginação - somar a qtd de itens
        if (!empty($data_inicial)) {
            $result_pg = "SELECT COUNT(id) AS num_result FROM financeiro WHERE id_empresa = '$id' AND datavenc_at BETWEEN '$data_inicial' AND '$data_final' AND tipo IN ('E', 'S')";
        } else {
            $result_pg = "SELECT COUNT(id) AS num_result FROM financeiro WHERE id_empresa = '$id' AND tipo IN ('E', 'S')";
        }
        $resultado_pg = mysqli_query($conexao, $result_pg);
        $row_pg = mysqli_fetch_assoc($resultado_pg);
        //echo $row_pg['num_result'];
        //qtd de páginas

        $quantidade_pg = ceil($row_pg['num_result'] / $qtd_result_pg);
        if ($pagina_atual != '') {
            echo "<p class='fs-6 text-center'>Página " . $pagina_atual . " de " . $quantidade_pg . " | Total de registros " . $row_pg['num_result'] . "</p>";
        } else {
            echo "<p class='fs-6 text-center'>Página 1 de " . $quantidade_pg . " | Total de registros " . $row_pg['num_result'] . "</p>";
        }
        if ($row_pg['num_result'] > $qtd_result_pg) {
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


        echo "</div>";
    }
