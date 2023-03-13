<?php
session_start();
include('../db/conexao.php');

$id = (int)$_SESSION['id_emp'];
$data_inicial = $_POST['data_inicio'];
$data_final = $_POST['data_final'];

$_SESSION['dt_inicio'] = $data_inicial;
$_SESSION['dt_final'] = $data_final;

$data_inicial = implode("-", array_reverse(explode("/", $data_inicial)));
$data_final = implode("-", array_reverse(explode("/", $data_final)));

if (!empty($data_inicial) && !empty($data_final)) {
    $result_financeiro = "SELECT * FROM financeiro WHERE id_empresa = '$id' AND datavenc_at BETWEEN '$data_inicial' AND '$data_final' AND tipo IN ('E', 'S') ORDER BY datavenc_at DESC";

    $resultado_financeiro = mysqli_query($conexao, $result_financeiro);

    $result_pagos = "SELECT COUNT(*) AS num_result FROM financeiro WHERE id_empresa = '$id' AND datavenc_at BETWEEN '$data_inicial' AND '$data_final' AND tipo IN ('E', 'S')";
} else {
    $result_financeiro = "SELECT * FROM financeiro WHERE id_empresa = '$id' AND tipo IN ('E', 'S') ORDER BY datavenc_at DESC";

    $resultado_financeiro = mysqli_query($conexao, $result_financeiro);

    $result_pagos = "SELECT COUNT(*) AS num_result FROM financeiro WHERE id_empresa = '$id' AND tipo IN ('E', 'S')";
}
$resultado_pagos = mysqli_query($conexao, $result_pagos);
$row_pagos = mysqli_fetch_assoc($resultado_pagos);

if ($row_pagos['num_result'] != 0) {
    //echo "<p>Data inicial: " . $data_inicial . "Data final: " . $data_final . "</p>";
    //echo "<div class='scroll'>";
    echo "<div class='table_rp mx-auto'>";
    echo "<div class='mx-auto bg-white border border-top-0 border-start-0 border-end-0 border-secondary py-1'>";
    echo "<p class='text-center mx-auto'><span style='font-weight: bold;'>Relatório de Recebidos e Pagos</span></p>";
    if (!empty($data_inicial) && !empty($data_final)) {
        echo "<p class='text-center mx-auto' id='sub_titulo'><span style='font-weight: 500;'>Período de: " . date('d/m/Y', strtotime($_POST['data_inicio'])) . " a " . date('d/m/Y', strtotime($_POST['data_final'])) . "</span></p>";
    } else {
        echo "<p class='text-center mx-auto' id='sub_titulo'><span style='font-weight: 500;'>Lista Completa dos Dados</span></p>";
    }
    echo "</div>";


    echo "</div>";
    echo "<table class='table table-hover border-top' id='fundo'>";
    echo "<thead class='table-primary border-bottom'>";
    echo "<tr>";
    echo "<th scope='col'>ID</th>";
    echo "<th style='width: 20%;'>Categoria</th>";
    echo "<th style='width: 30%;'>Descrição</th>";
    echo "<th style='width: 10%;'>Unidade</th>";
    echo "<th style='width: 10%;'>Bloco</th>";
    echo "<th style='width: 15%'>Valor</th>";
    echo "<th style='width: 15%'>Data Venc.</th>";
    echo "<th style='width: 5%;'>Tipo</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

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
        echo "<td class='fs-6' id='id" . $row_financeiro['id'] . "'>" . $row_financeiro['id'] . "</td>";
        echo "<td class='fs-6' id='ed_grupo" . $row_financeiro['id'] . "'>" . $row_financeiro['grupo'] . "</td>";
        echo "<td class='fs-6' id='ed_descricao" . $row_financeiro['id'] . "'>" . $row_financeiro['descricao'] . "</td>";
        echo "<td class='fs-6' id='ed_unidade" . $row_financeiro['id'] . "'>" . $row_financeiro['unidade'] . "</td>";
        echo "<td class='fs-6' id='ed_bloco" . $row_financeiro['id'] . "'>" . $row_financeiro['bloco'] . "</td>";
        echo "<td class='fs-6' id='ed_valorr" . $row_financeiro['id'] . "'>" . $taxa . "</td>";
        echo "<td class='fs-6' id='ed_datavenc" . $row_financeiro['id'] . "'>" . $datavenc . "</td>";
        if ($row_financeiro['tipo'] === "E") {
            echo "<td><i class='fa-regular fa-circle-up ms-1 text-success' style='font-size: 1.3rem;'></i></td>";
        } elseif ($row_financeiro['tipo'] === "S") {
            echo "<td><i class='fa-regular fa-circle-down ms-1' style='font-size: 1.3rem; color:brown;'></i></td>";
        } elseif ($row_financeiro['tipo'] === "D") {
            echo "<td><i class='fa-regular fa-circle-down ms-1 text-warning' style='font-size: 1.3rem;'></i></td>";
        } elseif ($row_financeiro['tipo'] === "P") {
            echo "<td><i class='fa-regular fa-circle-up ms-1 text-warning' style='font-size: 1.3rem;'></i></td>";
        }

        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    //echo "</div>";
}
$conexao->close();
