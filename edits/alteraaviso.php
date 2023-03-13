<?php
session_start();
include("../db/conexao.php");

$id = mysqli_real_escape_string($conexao, trim($_POST['id_edit']));
$titulo_edit = mysqli_real_escape_string($conexao, trim($_POST['titulo_edit']));
$data_edit = mysqli_real_escape_string($conexao, trim($_POST['data_edit']));
$descricao_edit = mysqli_real_escape_string($conexao, trim($_POST['descricao_edit']));
$bgcolors_edit = mysqli_real_escape_string($conexao, trim($_POST['bgcolors_edit']));
$id_usuario = $_SESSION['id_user_log'];
$usuario = $_SESSION['nome'];
$ativo = (isset($_POST['ativo_edit'])) ? '1' : '0';
if ($ativo === '1') {
    $fixo = (isset($_POST['fixo_edit'])) ? '1' : '0';
} else {
    $fixo = '0';
}

$data_edit = implode("-", array_reverse(explode("/", $data_edit)));

$sql_edit = "UPDATE quadro SET titulo='$titulo_edit', datavenc_at='$data_edit', mensagem='$descricao_edit', bgcolor='$bgcolors_edit', id_usuario='$id_usuario',
            usuario='$usuario', visivel='$ativo', fixo='$fixo',updated_at=NOW()
	        WHERE id = '$id'";
/*$resultado = mysqli_query($conexao, $sql_edit);*/

if ($conexao->query($sql_edit) === true) {
    $_SESSION['nao_alterou'] = true;
    header('Location: ../cadastros/quadro-de-avisos');
    mysqli_close($conexao);
    exit();
} else {
    $_SESSION['nao_alterou'] = false;
    header('Location: ../cadastros/quadro-de-avisos');
    mysqli_close($conexao);
    exit();
}
