<?php
session_start();
//ob_start();
include("../db/conexao.php");

unset($_SESSION['financeiro_upload_size']);
if (isset($_FILES['arquivo'])) {
    $arquivo = $_FILES['arquivo'];
    $extensao = strtolower(substr($_FILES['arquivo']['name'], -4));
    $novo_nome = mysqli_real_escape_string($conexao, trim($_POST['novo_nome'])) . $extensao;
    $id_financeiro_upload = mysqli_real_escape_string($conexao, trim($_POST['id_financeiro_upload'])) . $extensao;
    $usuario = $_SESSION['id_user_log'];

    $_UP['extensoes'] = array('jpg', 'pdf');

    if ($_FILES["arquivo"]["type"] != "application/pdf" && $_FILES["arquivo"]["type"] != "image/jpeg") {
        $_SESSION['financeiro_upload_fail'] = true;
        header('Location: ../cadastros/arrecadacoes');
        mysqli_close($conexao);
        exit();
    }
    $maximo = 50000;
    if ($_FILES["arquivo"]["size"] > (1024 * 1024 * 5)) {
        $_SESSION['financeiro_upload_size'] = true;
        header('Location: ../cadastros/arrecadacoes');
        mysqli_close($conexao);
        exit();
    }

    move_uploaded_file($_FILES['arquivo']['tmp_name'], "../assets/comprovantes/" . $novo_nome);

    $sql_edit = "UPDATE financeiro SET documento='$novo_nome', id_usuario='$usuario', updated_at=NOW()
	        WHERE id = '$id_financeiro_upload'";

    if ($conexao->query($sql_edit) === true) {
        $_SESSION['financeiro_upload'] = true;
        header('Location: ../cadastros/arrecadacoes');
        mysqli_close($conexao);
        exit();
    }
}
