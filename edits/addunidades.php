<?php
session_start();
include("../db/conexao.php");

/*$id = mysqli_real_escape_string($conexao, trim($_POST['id_emp']));*/
$id = (int)$_SESSION['id_emp'];
$bloco_id = mysqli_real_escape_string($conexao, trim($_POST['id_bloc']));
$bloco_add = mysqli_real_escape_string($conexao, trim($_POST['bloco-add']));
$unidade_add = mysqli_real_escape_string($conexao, trim($_POST['unidade-add']));
$usuario = $_SESSION['id_user_log'];

$sql = "SELECT count(*) as total FROM unidades WHERE id_empresa = '$id' AND bloco = '$bloco_add'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] > 15) {
    $_SESSION['total_unidades'] = true;
    header('Location: ../cadastros/definicao-de-unidades');
    exit;
}

$sql = "INSERT INTO unidades (id_empresa, id_bloco, bloco, unidade, id_usuario, ativo,
 created_at, updated_at) VALUES ('$id', '$bloco_id', '$bloco_add', '$unidade_add', '$usuario', '1', NOW(), NOW())";
/*$resultado_sql = mysqli_query($conexao, $sql);*/
if ($conexao->query($sql) === true) {
    $_SESSION['cadastro_unidade'] = true;
    $conexao->close();

    header('Location: ../cadastros/definicao-de-unidades');
    exit;
} else {
    $_SESSION['cadastro_unidade'] = false;
}

$conexao->close();

header('Location: ../cadastros/definicao-de-unidades');
exit;
