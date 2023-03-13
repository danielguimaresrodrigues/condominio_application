<?php
session_start();
include("../db/conexao.php");

/*$id = mysqli_real_escape_string($conexao, trim($_POST['id_emp']));*/
$id = (int)$_SESSION['id_emp'];
$bloco_add = mysqli_real_escape_string($conexao, trim($_POST['bloco_add']));
$taxa_add = mysqli_real_escape_string($conexao, trim($_POST['taxa_add']));
$observacao_add = mysqli_real_escape_string($conexao, trim($_POST['observacao_add']));
$usuario = $_SESSION['id_user_log'];

$sql = "SELECT count(*) as total FROM blocos WHERE id_empresa = '$id'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

$sql = "INSERT INTO blocos (id_empresa, bloco, taxa_cond, observacao, id_usuario, ativo,
 created_at, updated_at) VALUES ('$id', '$bloco_add', '$taxa_add', '$observacao_add', '$usuario', '1', NOW(), NOW())";
/*$resultado_sql = mysqli_query($conexao, $sql);*/
if ($conexao->query($sql) === true) {
    $_SESSION['cadastro_bloco'] = true;
    $conexao->close();

    header('Location: ../cadastros/definicao-de-blocos');
    exit;
} else {
    $_SESSION['status_cadastro'] = false;
}

$conexao->close();

header('Location: ../cadastros/definicao-de-blocos');
exit;
