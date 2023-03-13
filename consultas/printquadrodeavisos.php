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
    $result_quadro = "SELECT * FROM quadro WHERE id_empresa = '$id' AND datavenc_at BETWEEN '$data_inicial' AND '$data_final' AND visivel = '1' ORDER BY datavenc_at DESC";

    $resultado_quadro = mysqli_query($conexao, $result_quadro);

    $result_avisos = "SELECT COUNT(*) AS num_result FROM quadro WHERE id_empresa = '$id' AND datavenc_at BETWEEN '$data_inicial' AND '$data_final' AND visivel = '1'";
} else {
    $result_quadro = "SELECT * FROM quadro WHERE id_empresa = '$id' AND visivel = '1' ORDER BY datavenc_at DESC";

    $resultado_quadro = mysqli_query($conexao, $result_quadro);

    $result_avisos = "SELECT COUNT(*) AS num_result FROM quadro WHERE id_empresa = '$id' AND visivel = '1'";
}
$resultado_avisos = mysqli_query($conexao, $result_avisos);
$row_avisos = mysqli_fetch_assoc($resultado_avisos);

if ($row_avisos['num_result'] != 0) {
    echo "<div class='table_rp mx-auto'>";
    echo "<div class='mx-auto bg-white border border-top-0 border-start-0 border-end-0 border-secondary py-1 mb-4'>";
    echo "<p class='text-center mx-auto'><span style='font-weight: bold;'>Relatório de Quadro de Avisos</span></p>";
    if (!empty($data_inicial) && !empty($data_final)) {
        echo "<p class='text-center mx-auto' id='sub_titulo'><span style='font-weight: 500;'>Período de: " . date('d/m/Y', strtotime($_POST['data_inicio'])) . " a " . date('d/m/Y', strtotime($_POST['data_final'])) . "</span></p>";
    } else {
        echo "<p class='text-center mx-auto' id='sub_titulo'><span style='font-weight: 500;'>Lista Completa dos Dados</span></p>";
    }
    echo "</div>";

    while ($row_quadro = mysqli_fetch_assoc($resultado_quadro)) {

        echo "<div class='container-fluid mt-2'>";
        echo "<div class='col-sm-12 mx-auto px-3 border border-secondary shadow-sm rounded-3 align-self-center bg-white'>";
        echo "<div class='row d-flex justify-content-between bg-white'>";
        echo "<div class='col-sm-12'>";
        echo "<h6 class='fw-bold pt-3'>" . $row_quadro['titulo'] . "</h6>";
        echo "</div>";
        echo "<div class='col-sm-12 d-flex'>";
        echo "<span><i class='bi bi-calendar3 text-primary fs-3 me-1'></i></span><span class='fs-6 fst-normal text-secondary mx-2'>" . date('d/m/Y', strtotime($row_quadro['datavenc_at'])) . "<span class='mx-2'>|</span><span><i class='bi bi-person-fill text-primary fs-3'></i></span><span class='ms-1'>" . $row_quadro['usuario'] . "</span>";
        echo "</div>";

        echo "<div class='col-sm-12'>";
        echo "<p class='fw-normal pt-2' style='font-size: medium;'>" . $row_quadro['mensagem'] . "</p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
}
$conexao->close();
