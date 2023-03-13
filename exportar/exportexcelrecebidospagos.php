<?php
session_start();
ob_start();

include('../db/conexao.php');

$id = (int)$_SESSION['id_emp'];
$data_inicial = mysqli_real_escape_string($conexao, trim($_POST['data_ini']));
$data_final = mysqli_real_escape_string($conexao, trim($_POST['data_fim']));

$data_inicial = implode("-", array_reverse(explode("/", $data_inicial)));
$data_final = implode("-", array_reverse(explode("/", $data_final)));

if (!empty($data_inicial) && !empty($data_final)) {
    $result_financeiro = "SELECT id, id_empresa, unidade, bloco, tipo, valor, grupo, descricao, datavenc_at, created_at, updated_at
     FROM financeiro WHERE id_empresa = '$id' AND datavenc_at BETWEEN '$data_inicial' AND '$data_final' AND tipo IN ('E', 'S') ORDER BY datavenc_at DESC";

    $resultado_financeiro = mysqli_query($conexao, $result_financeiro);

    $result_pagos = "SELECT COUNT(*) AS num_result FROM financeiro WHERE id_empresa = '$id' AND datavenc_at BETWEEN '$data_inicial' AND '$data_final' AND tipo IN ('E', 'S')";
} else {
    $result_financeiro = "SELECT id, id_empresa, unidade, bloco, tipo, valor, grupo, descricao, datavenc_at, created_at, updated_at
     FROM financeiro WHERE id_empresa = '$id' AND tipo IN ('E', 'S') ORDER BY datavenc_at DESC";

    $resultado_financeiro = mysqli_query($conexao, $result_financeiro);

    $result_pagos = "SELECT COUNT(*) AS num_result FROM financeiro WHERE id_empresa = '$id' AND tipo IN ('E', 'S')";
}
$resultado_pagos = mysqli_query($conexao, $result_pagos);

/*<!--!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>gestorr | Gestão para Condomínios</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body-->

// Definimos o nome do arquivo que será exportado
/*$arquivo = 'Relatório de Recebidos e Pagos.xls';

    // Criamos uma tabela HTML com o formato da planilha
    $html = '';
    $html .= '<table border="1">';
    $html .= '<tr>';
    $html .= '<td colspan="11">Relatório de Recebidos e Pagos</tr>';
    $html .= '</tr>';


    $html .= '<tr>';
    $html .= '<td><b>id</b></td>';
    $html .= '<td><b>id_empresa</b></td>';
    $html .= '<td><b>Unidade</b></td>';
    $html .= '<td><b>Bloco</b></td>';
    $html .= '<td><b>Tipo</b></td>';
    $html .= '<td><b>Valor</b></td>';
    $html .= '<td><b>Grupo</b></td>';
    $html .= '<td><b>Descrição</b></td>';
    $html .= '<td><b>Vencimento</b></td>';
    $html .= '<td><b>Created_at</b></td>';
    $html .= '<td><b>Updated_at</b></td>';
    $html .= '</tr>';*/

// Aceitar csv ou texto 
header('Content-Type: text/csv; charset=utf-8');

// Nome arquivo
header('Content-Disposition: attachment; filename=Relatório-de-Recebidos-e-Pagos.csv');

// Gravar no buffer
$resultado = fopen("php://output", 'w');

// Criar o cabeçalho do Excel - Usar a função mb_convert_encoding para converter carateres especiais
$cabecalho = ['id', 'id_empresa', 'Unidade', 'Bloco', 'Tipo', 'Valor', 'Categoria', mb_convert_encoding('Descrição', 'ISO-8859-1', 'UTF-8'), 'Vencimento', 'Created_at', 'Updated_at'];

// Escrever o cabeçalho no arquivo
fputcsv($resultado, $cabecalho, ';');
while ($row_financeiro = mysqli_fetch_assoc($resultado_financeiro)) {
    $dados = [
        $row_financeiro['id'], $row_financeiro['id_empresa'], mb_convert_encoding($row_financeiro['unidade'], 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($row_financeiro['bloco'], 'ISO-8859-1', 'UTF-8'), $row_financeiro['tipo'], number_format($row_financeiro["valor"], 2, ',', '.'),
        mb_convert_encoding($row_financeiro['grupo'], 'ISO-8859-1', 'UTF-8'), mb_convert_encoding($row_financeiro['descricao'], 'ISO-8859-1', 'UTF-8'), date('d/m/Y', strtotime($row_financeiro["datavenc_at"])),
        date('d/m/Y H:i:s', strtotime($row_financeiro["created_at"])), date('d/m/Y H:i:s', strtotime($row_financeiro["updated_at"]))
    ];
    // Escrever o conteúdo no arquivo
    fputcsv($resultado, $dados, ';');
}
//Fechar o arquivo
fclose($resultado);
$conexao->close();


//<!--/body-->

//</html-->