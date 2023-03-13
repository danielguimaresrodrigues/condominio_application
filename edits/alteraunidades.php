<?php
session_start();
include('../db/conexao.php');

$id = mysqli_real_escape_string($conexao, trim($_POST['id_unidade']));
$bloco = mysqli_real_escape_string($conexao, trim($_POST['unidade-edit']));
$unidade = mysqli_real_escape_string($conexao, trim($_POST['bloco-edit']));
$usuario = $_SESSION['id_user_log'];

$sql_edit = "UPDATE unidades SET bloco='$bloco', unidade='$unidade', id_usuario='$usuario',updated_at=NOW()
	        WHERE id = '$id'";
/*$resultado = mysqli_query($conexao, $sql_edit);*/

if ($conexao->query($sql_edit) === true) {
    $_SESSION['nao_alterou'] = true;
    header('Location: ../cadastros/definicao-de-unidades');
    mysqli_close($conexao);
    exit();
} else {
    $_SESSION['nao_alterou'] = false;
    header('Location: ../cadastros/definicao-de-unidades');
    mysqli_close($conexao);
    exit();
}
