<?php
session_start();
include("../db/conexao.php");

// Receber a imagem
$id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
$arquivo = 'Foto' . $id . '.png';
$foto = null;

if (file_exists("../assets/avatars/" . $arquivo)) {
    unlink("../assets/avatars/" . $arquivo);
}

$sql_edit = "UPDATE login SET foto=null, updated_at=NOW()
WHERE id = '$id'";

if ($conexao->query($sql_edit) === true) {
    $_SESSION['foto'] = null;
    header('Location: ../cadastros/personaldata');
}
mysqli_close($conexao);
