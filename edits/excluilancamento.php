<?php
session_start();
include("../db/conexao.php");

$id_empresa = (int)$_SESSION['id_emp'];
$id = mysqli_real_escape_string($conexao, trim($_POST['id_financeiro_trash']));
$tipo_edits = mysqli_real_escape_string($conexao, trim($_POST['tipo_edits_excluir']));

/*$sql = "SELECT count(*) as total FROM unidades WHERE id_empresa = '$id_empresa' AND bloco = '$id_bloco'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] > 0) {
    $_SESSION['exist_unidades'] = true;
    header('Location: ../cadastros/definicao-de-blocos');
    exit;
}*/

$sql_edit = "DELETE FROM financeiro WHERE id = '$id'";
/*$resultado = mysqli_query($conexao, $sql_edit);

$sql_edit = "UPDATE blocos SET ativo='0', updated_at=NOW()
	        WHERE id = '$id'";*/

if ($conexao->query($sql_edit) === true) {
    $_SESSION['status_deletagrupo'] = true;
} else {
    $_SESSION['status_deletagrupo'] = false;
}

$conexao->close();
if ($tipo_edits === 'Recebido' || $tipo_edits === 'Pago') {
    header('Location: ../cadastros/arrecadacoes');
} elseif ($tipo_edits === 'A pagar') {
    header('Location: ../cadastros/pagamentosfuturos');
} elseif ($tipo_edits === 'A receber') {
    header('Location: ../cadastros/recebimentosfuturos');
}
exit;
