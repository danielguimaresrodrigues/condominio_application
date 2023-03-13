<?php
session_start();
include('../db/conexao.php');

$id = mysqli_real_escape_string($conexao, trim($_POST['id_bloco']));
$taxa_edit = mysqli_real_escape_string($conexao, trim($_POST['taxa_edit']));
$bloco = mysqli_real_escape_string($conexao, trim($_POST['bloco']));
$observacao = mysqli_real_escape_string($conexao, trim($_POST['observacao']));
$usuario = $_SESSION['id_user_log'];

$sql_edit = "UPDATE blocos SET bloco='$bloco', taxa_cond='$taxa_edit', observacao='$observacao', id_usuario='$usuario',updated_at=NOW()
	        WHERE id = '$id'";
/*$resultado = mysqli_query($conexao, $sql_edit);*/

if ($conexao->query($sql_edit) === true) {
    $_SESSION['nao_alterou'] = true;
    header('Location: ../cadastros/definicao-de-blocos');
    mysqli_close($conexao);
    exit();
} else {
    $_SESSION['nao_alterou'] = false;
    header('Location: ../cadastros/definicao-de-blocos');
    mysqli_close($conexao);
    exit();
}
