<?php
session_start();
include("../db/conexao.php");

/*$id = mysqli_real_escape_string($conexao, trim($_POST['id_emp']));*/
$id = mysqli_real_escape_string($conexao, trim($_POST['id_edits']));
$valor_edits = mysqli_real_escape_string($conexao, trim($_POST['valor_edits']));
$descricao_edits = mysqli_real_escape_string($conexao, trim($_POST['descricao_edits']));
$tipo_edits = mysqli_real_escape_string($conexao, trim($_POST['tipo_edits']));
$usuario = $_SESSION['id_user_log'];

/*$sql = "SELECT count(*) as total FROM unidades WHERE id_empresa = '$id' AND bloco = '$bloco_add'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] > 15) {
    $_SESSION['total_unidades'] = true;
    header('Location: ../cadastros/definicao-de-unidades');
    exit;
}*/

$sql_edit = "UPDATE financeiro SET valor='$valor_edits', descricao='$descricao_edits', id_usuario='$usuario', updated_at=NOW()
	        WHERE id = '$id'";
/*$resultado = mysqli_query($conexao, $sql_edit);*/

if ($conexao->query($sql_edit) === true) {
    $_SESSION['nao_alterou'] = true;
    if ($tipo_edits === 'Recebido' || $tipo_edits === 'Pago') {
        header('Location: ../cadastros/arrecadacoes');
    } elseif ($tipo_edits === 'A pagar') {
        header('Location: ../cadastros/pagamentosfuturos');
    } elseif ($tipo_edits === 'A receber') {
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
