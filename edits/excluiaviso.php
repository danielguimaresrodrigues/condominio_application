<?php
session_start();
include("../db/conexao.php");

$id = mysqli_real_escape_string($conexao, trim($_POST['id_aviso_trash']));

$sql_edit = "DELETE FROM quadro WHERE id='$id'";
/*$resultado = mysqli_query($conexao, $sql_edit);*/

if ($conexao->query($sql_edit) === true) {
    $_SESSION['status_deletabloc'] = true;
} else {
    $_SESSION['status_deletabloc'] = false;
}

$conexao->close();

header('Location: ../cadastros/quadro-de-avisos');
exit;
