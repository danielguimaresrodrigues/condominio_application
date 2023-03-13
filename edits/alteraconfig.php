<?php
session_start();
include('../db/conexao.php');

$id = (int)$_SESSION['id_emp'];
$itens_pag = (int)$_POST['itens_pag'];
$location = mysqli_real_escape_string($conexao, trim($_POST['tela']));
$usuario = $_SESSION['id_user_log'];

$sql_edit = "UPDATE configuracoes SET itens_pag='$itens_pag', id_usuario='$usuario', updated_at=NOW()
	        WHERE id_empresa = '$id' AND id_usuario = '$usuario'";
/*$resultado = mysqli_query($conexao, $sql_edit);*/

if ($conexao->query($sql_edit) === true) {
    $_SESSION['itens_pag'] = $itens_pag;
    if ($location === 'arrecadacoes') {
        header('Location: ../cadastros/arrecadacoes');
    } elseif ($location === 'a_pagar') {
        header('Location: ../cadastros/pagamentosfuturos');
    } elseif ($location === 'recebimentosfuturos') {
        header('Location: ../cadastros/recebimentosfuturos');
    }
    mysqli_close($conexao);
    exit();
} else {
    $_SESSION['nao_alterou'] = false;
    header('Location: ../cadastros/arrecadacoes');
    mysqli_close($conexao);
    exit();
}
