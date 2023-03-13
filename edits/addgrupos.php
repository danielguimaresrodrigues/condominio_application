<?php
session_start();
include("../db/conexao.php");

/*$id = mysqli_real_escape_string($conexao, trim($_POST['id_emp']));*/
$id = (int)$_SESSION['id_emp'];
$grupo_add = mysqli_real_escape_string($conexao, trim($_POST['grupo_add']));
$usuario = $_SESSION['id_user_log'];

$sql = "SELECT count(*) as total FROM grupos WHERE id_empresa = '$id' AND grupo = '$grupo_add'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] != 0) {
    $_SESSION['consult_grupo'] = true;
    header('Location: ../cadastros/definicao-de-grupos');
    $conexao->close();
    exit;
}

$sql = "INSERT INTO grupos (id_empresa, grupo, ativo, id_usuario,
 created_at, updated_at) VALUES ('$id', '$grupo_add', '$usuario', '1', NOW(), NOW())";
/*$resultado_sql = mysqli_query($conexao, $sql);*/
if ($conexao->query($sql) === true) {
    $_SESSION['cadastro_grupo'] = true;
    $conexao->close();

    header('Location: ../cadastros/definicao-de-categorias');
    exit;
} else {
    $_SESSION['status_cadastro'] = false;
}

$conexao->close();

header('Location: ../cadastros/definicao-de-categorias');
exit;
