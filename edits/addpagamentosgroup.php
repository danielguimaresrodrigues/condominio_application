<?php
session_start();
include("../db/conexao.php");

/*$id = mysqli_real_escape_string($conexao, trim($_POST['id_emp']));*/
$id = (int)$_SESSION['id_emp'];
$unidades_adds_group = mysqli_real_escape_string($conexao, trim($_POST['unidades_adds_group']));
$grupo_adds_group = mysqli_real_escape_string($conexao, trim($_POST['grupo_adds_group']));
$bloco_adds_group = mysqli_real_escape_string($conexao, trim($_POST['bloco_adds_group']));
$valor_adds_group = mysqli_real_escape_string($conexao, trim($_POST['valor_adds_group']));
$data_adds_group = mysqli_real_escape_string($conexao, trim($_POST['data_adds_group']));
$tipo_adds_group = mysqli_real_escape_string($conexao, trim($_POST['tipo_adds_group']));
$descricao_adds_group = mysqli_real_escape_string($conexao, trim($_POST['descricao_adds_group']));
$usuario = $_SESSION['id_user_log'];

$data_adds_group = implode("-", array_reverse(explode("/", $data_adds_group)));
$grupo = explode("|", $grupo_adds_group);
$bloco = explode("|", $bloco_adds_group);

$unidades_total = explode(",", $unidades_adds_group);

$id_grupo = $grupo[0];
$grupo = $grupo[1];

$id_bloco = $bloco[0];
$bloco_name = $bloco[1];

/*$sql = "SELECT count(*) as total FROM unidades WHERE id_empresa = '$id' AND bloco = '$bloco_add'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] > 15) {
    $_SESSION['total_unidades'] = true;
    header('Location: ../cadastros/definicao-de-unidades');
    exit;
}*/
foreach ($unidades_total as $key => $value) {
    $unidade_separa = explode("|", $value);
    $sql = "INSERT INTO financeiro (id_empresa, id_unidade, unidade, id_bloco, bloco, tipo, valor, id_grupo, grupo,
    descricao, datavenc_at, id_usuario, created_at, updated_at) VALUES ('$id', '$unidade_separa[0]', '$unidade_separa[1]',
    '$id_bloco', '$bloco_name', '$tipo_adds_group', '$valor_adds_group', '$id_grupo', '$grupo', '$descricao_adds', '$data_adds_group', '$usuario', NOW(), NOW())";
    /*$resultado_sql = mysqli_query($conexao, $sql);*/
    if ($conexao->query($sql) === true) {
    }
}

$_SESSION['cadastro_arrecadacao'] = true;
$conexao->close();

header('Location: ../cadastros/arrecadacoes');
exit;
/*
} else {
    $_SESSION['cadastro_arrecadacao'] = false;
}

$conexao->close();

header('Location: ../cadastros/arrecadacoes');
exit;*/
