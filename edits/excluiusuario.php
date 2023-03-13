<?php
session_start();
include("../db/conexao.php");

$id = mysqli_real_escape_string($conexao, trim($_POST['id_user_trash']));

$sql_edit = "DELETE FROM login WHERE id='$id'";
/*$resultado = mysqli_query($conexao, $sql_edit);*/

if ($conexao->query($sql_edit) === true) {
    $sql_delete = "DELETE FROM configuracoes WHERE id_usuario='$id'";

    if ($conexao->query($sql_delete) === true) {
        $_SESSION['status_deletabloc'] = true;
    }
} else {
    $_SESSION['status_deletabloc'] = false;
}

$conexao->close();

header('Location: ../cadastros/gerenciamento-de-usuarios');
exit;
