<?php
session_start();
include("../db/conexao.php");

/*$id = mysqli_real_escape_string($conexao, trim($_POST['id_emp']));*/
$id = (int)$_SESSION['id_emp'];
$titulo_add = mysqli_real_escape_string($conexao, trim($_POST['titulo_add']));
$data_adds = mysqli_real_escape_string($conexao, trim($_POST['data_adds']));
$descricao_adds = mysqli_real_escape_string($conexao, trim($_POST['descricao_adds']));
$bgcolors = mysqli_real_escape_string($conexao, trim($_POST['bgcolors']));
$id_usuario = $_SESSION['id_user_log'];
$usuario = $_SESSION['nome'];
$fixo = (isset($_POST['fixo'])) ? '1' : '0';

$data_adds = implode("-", array_reverse(explode("/", $data_adds)));

$sql = "INSERT INTO quadro (id_empresa, titulo, mensagem, datavenc_at, id_usuario, usuario, bgcolor, visivel, fixo,
 created_at, updated_at) VALUES ('$id', '$titulo_add', '$descricao_adds', '$data_adds', '$id_usuario', '$usuario', '$bgcolors', '1', '$fixo', NOW(), NOW())";
/*$resultado_sql = mysqli_query($conexao, $sql);*/
if ($conexao->query($sql) === true) {
    $_SESSION['status_cadastro'] = true;
    $conexao->close();

    header('Location: ../cadastros/quadro-de-avisos');
    exit;
} else {
    $_SESSION['status_cadastro'] = false;
}

$conexao->close();

header('Location: ../cadastros/quadro-de-avisos');
exit;
