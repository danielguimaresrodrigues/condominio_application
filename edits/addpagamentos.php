<?php
session_start();
include("../db/conexao.php");

/*$id = mysqli_real_escape_string($conexao, trim($_POST['id_emp']));*/
$id = (int)$_SESSION['id_emp'];
$unidade_adds = mysqli_real_escape_string($conexao, trim($_POST['unidade_adds']));
$grupo_adds = mysqli_real_escape_string($conexao, trim($_POST['grupo_adds']));
$bloco_adds = mysqli_real_escape_string($conexao, trim($_POST['bloco_adds']));
$valor_adds = mysqli_real_escape_string($conexao, trim($_POST['valor_adds']));
$data_adds = mysqli_real_escape_string($conexao, trim($_POST['data_adds']));
$tipo_adds = mysqli_real_escape_string($conexao, trim($_POST['tipo_adds']));
$descricao_adds = mysqli_real_escape_string($conexao, trim($_POST['descricao_adds']));
$usuario = $_SESSION['id_user_log'];

$data_adds = implode("-", array_reverse(explode("/", $data_adds)));
$unidade = explode("|", $unidade_adds);
$grupo = explode("|", $grupo_adds);
$bloco = explode("|", $bloco_adds);

$id_unidade = $unidade[0];
$unidade_name = $unidade[1];

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

$sql = "INSERT INTO financeiro (id_empresa, id_unidade, unidade, id_bloco, bloco, tipo, valor, id_grupo, grupo,
    descricao, datavenc_at, id_usuario, created_at, updated_at) VALUES ('$id', '$id_unidade', '$unidade_name',
    '$id_bloco', '$bloco_name', '$tipo_adds', '$valor_adds', '$id_grupo', '$grupo', '$descricao_adds', '$data_adds', '$usuario', NOW(), NOW())";
/*$resultado_sql = mysqli_query($conexao, $sql);*/
if ($conexao->query($sql) === true) {
    $_SESSION['cadastro_arrecadacao'] = true;
    $conexao->close();

    header('Location: ../cadastros/arrecadacoes');
    exit;
} else {
    $_SESSION['cadastro_arrecadacao'] = false;
}

$conexao->close();

header('Location: ../cadastros/arrecadacoes');
exit;
